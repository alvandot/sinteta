<?php

namespace App\Services\Contracts;

use App\Models\User;
use Illuminate\Support\Collection;

interface UserServiceInterface
{
    /**
     * Get all users with their roles and cabang
     *
     * @return Collection
     */
    public function getAllUsers(): Collection;

    /**
     * Get all tentors with their user data
     *
     * @return Collection
     */
    public function getTentors(): Collection;

    /**
     * Get all siswa with their user data
     *
     * @return Collection
     */
    public function getSiswa(): Collection;

    /**
     * Create a new user
     *
     * @param array $data
     * @return User
     */
    public function createUser(array $data): User;

    /**
     * Update an existing user
     *
     * @param int $id
     * @param array $data
     * @return User
     */
    public function updateUser(int $id, array $data): User;

    /**
     * Delete a user
     *
     * @param int $id
     * @return bool
     */
    public function deleteUser(int $id): bool;

    /**
     * Find a user by ID
     *
     * @param int $id
     * @return User|null
     */
    public function findUserById(int $id): ?User;

    /**
     * Get users by role
     *
     * @param string $role
     * @return Collection
     */
    public function getUsersByRole(string $role): Collection;
}
