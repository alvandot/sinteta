<?php

namespace App\Services\Implementations;

use App\Services\Contracts\UserServiceInterface;
use App\Models\User;
use App\Models\Users\Tentor;
use App\Models\Users\Siswa;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UserService implements UserServiceInterface
{
    protected $user;
    protected $tentor;
    protected $siswa;

    public function __construct(
        User $user,
        Tentor $tentor,
        Siswa $siswa
    ) {
        $this->user = $user;
        $this->tentor = $tentor;
        $this->siswa = $siswa;
    }

    /**
     * Get all users with their roles and cabang
     *
     * @return Collection
     */
    public function getAllUsers(): Collection
    {
        return $this->user->with(['roles', 'cabang'])->get();
    }

    /**
     * Get all tentors with their user data
     *
     * @return Collection
     */
    public function getTentors(): Collection
    {
        return $this->tentor->with(['user', 'user.roles', 'user.cabang'])->get();
    }

    /**
     * Get all siswa with their user data
     *
     * @return Collection
     */
    public function getSiswa(): Collection
    {
        return $this->siswa->with(['user', 'user.roles', 'user.cabang'])->get();
    }

    /**
     * Create a new user
     *
     * @param array $data
     * @return User
     * @throws ValidationException
     */
    public function createUser(array $data): User
    {
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|string|exists:roles,name',
            'cabang_id' => 'required|exists:cabang,id'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        try {
            return DB::transaction(function () use ($data) {
                $user = $this->user->create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => Hash::make($data['password']),
                    'cabang_id' => $data['cabang_id']
                ]);

                $user->assignRole($data['role']);

                // Create related model based on role
                if ($data['role'] === 'tentor') {
                    $this->tentor->create([
                        'user_id' => $user->id,
                        'nip' => $data['nip'] ?? null,
                        'mata_pelajaran' => $data['mata_pelajaran'] ?? null
                    ]);
                } elseif ($data['role'] === 'siswa') {
                    $this->siswa->create([
                        'user_id' => $user->id,
                        'nis' => $data['nis'] ?? null,
                        'kelas' => $data['kelas'] ?? null
                    ]);
                }

                return $user;
            });
        } catch (\Exception $e) {
            throw new \Exception('Gagal membuat user: ' . $e->getMessage());
        }
    }

    /**
     * Update an existing user
     *
     * @param int $id
     * @param array $data
     * @return User
     * @throws ValidationException
     */
    public function updateUser(int $id, array $data): User
    {
        $user = $this->user->findOrFail($id);

        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8',
            'role' => 'required|string|exists:roles,name',
            'cabang_id' => 'required|exists:cabang,id'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        try {
            return DB::transaction(function () use ($user, $data) {
                $updateData = [
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'cabang_id' => $data['cabang_id']
                ];

                if (!empty($data['password'])) {
                    $updateData['password'] = Hash::make($data['password']);
                }

                $user->update($updateData);

                // Update role if changed
                if (!$user->hasRole($data['role'])) {
                    $user->syncRoles([$data['role']]);
                }

                // Update related model based on role
                if ($data['role'] === 'tentor') {
                    $this->tentor->updateOrCreate(
                        ['user_id' => $user->id],
                        [
                            'nip' => $data['nip'] ?? null,
                            'mata_pelajaran' => $data['mata_pelajaran'] ?? null
                        ]
                    );
                } elseif ($data['role'] === 'siswa') {
                    $this->siswa->updateOrCreate(
                        ['user_id' => $user->id],
                        [
                            'nis' => $data['nis'] ?? null,
                            'kelas' => $data['kelas'] ?? null
                        ]
                    );
                }

                return $user->fresh(['roles', 'cabang']);
            });
        } catch (\Exception $e) {
            throw new \Exception('Gagal mengupdate user: ' . $e->getMessage());
        }
    }

    /**
     * Delete a user
     *
     * @param int $id
     * @return bool
     * @throws \Exception
     */
    public function deleteUser(int $id): bool
    {
        try {
            return DB::transaction(function () use ($id) {
                $user = $this->user->findOrFail($id);

                // Delete related models first
                if ($user->hasRole('tentor')) {
                    $this->tentor->where('user_id', $id)->delete();
                } elseif ($user->hasRole('siswa')) {
                    $this->siswa->where('user_id', $id)->delete();
                }

                return $user->delete();
            });
        } catch (\Exception $e) {
            throw new \Exception('Gagal menghapus user: ' . $e->getMessage());
        }
    }

    /**
     * Find a user by ID
     *
     * @param int $id
     * @return User|null
     */
    public function findUserById(int $id): ?User
    {
        return $this->user->with(['roles', 'cabang'])->find($id);
    }

    /**
     * Get users by role
     *
     * @param string $role
     * @return Collection
     * @throws ValidationException
     */
    public function getUsersByRole(string $role): Collection
    {
        $validator = Validator::make(['role' => $role], [
            'role' => 'required|string|exists:roles,name'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $this->user->role($role)->with(['roles', 'cabang'])->get();
    }
}
