<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

/**
 * Factory untuk membuat data dummy User
 * Factory ini digunakan untuk:
 * - Membuat data palsu untuk testing
 * - Mengisi database dengan data sample
 * - Memudahkan pembuatan data user dengan berbagai kondisi
 */
class UserFactory extends Factory
{
    /**
     * Menentukan model yang terkait dengan factory ini
     * Factory ini akan membuat instance dari model User
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Cache key untuk menyimpan password yang sudah di-hash
     */
    private const PASSWORD_CACHE_KEY = 'user_factory_password';

    /**
     * Password default untuk testing
     */
    private const DEFAULT_PASSWORD = 'password123';

    /**
     * Status yang tersedia untuk user
     */
    private const AVAILABLE_STATUSES = ['active', 'inactive', 'suspended'];

    /**
     * Role yang tersedia untuk user
     */
    private const AVAILABLE_ROLES = ['admin', 'tentor', 'akademik'];

    /**
     * Mendefinisikan state default untuk model User
     * Method ini menentukan nilai default untuk setiap kolom pada tabel users
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Menghasilkan nama palsu menggunakan Faker
            'name' => fake()->name(),

            // Menghasilkan email palsu yang unik untuk setiap user
            'email' => fake()->unique()->safeEmail(),

            // Default user sudah terverifikasi emailnya
            'email_verified_at' => now(),

            // Menggunakan password yang sudah di-hash
            // Jika belum ada password yang di-set, gunakan DEFAULT_PASSWORD
            'password' => $this->getHashedPassword(),

            // Token untuk fitur "Remember Me"
            'remember_token' => Str::random(10),

            'status' => 'active',
            // Timestamp pembuatan dan update record
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Mendapatkan password yang sudah di-hash dari cache
     */
    protected function getHashedPassword(): string
    {
        return Cache::remember(self::PASSWORD_CACHE_KEY, now()->addMinutes(60), function () {
            return Hash::make(self::DEFAULT_PASSWORD);
        });
    }

    /**
     * State untuk user yang belum verifikasi email
     * Berguna untuk testing fitur verifikasi email
     *
     * @return $this
     */
    public function unverified(): static
    {
        return $this->state(['email_verified_at' => null]);
    }

    /**
     * Method untuk mengatur password khusus
     * Contoh penggunaan: User::factory()->withPassword('rahasia123')->create()
     *
     * @param string $password
     * @return static
     */
    public function withPassword(string $password): static
    {
        return $this->state(['password' => Hash::make($password)]);
    }

    /**
     * State untuk user dengan status tertentu
     */
    public function withStatus(string $status): static
    {
        if (!in_array($status, self::AVAILABLE_STATUSES)) {
            throw new \InvalidArgumentException("Status '$status' tidak valid");
        }

        return $this->state(['status' => $status]);
    }

    /**
     * Method untuk membuat user admin
     * - Menambahkan role admin
     * - Menambahkan prefix 'admin.' pada email
     * Contoh penggunaan: User::factory()->asAdmin()->create()
     *
     * @return static
     */
    public function asAdmin(): static
    {
        return $this->state([
            'email' => 'admin.' . fake()->unique()->safeEmail(),
        ])->afterCreating(function (User $user) {
            $user->assignRole('admin');
        });
    }

    /**
     * State untuk user tentor
     */
    public function asTentor(): static
    {
        return $this->state([
            'email' => 'tentor.' . fake()->unique()->safeEmail(),
        ])->afterCreating(function (User $user) {
            $user->assignRole('tentor');
        });
    }

    /**
     * State untuk user siswa
     */
    public function asSiswa(): static
    {
        return $this->state([
            'email' => 'siswa.' . fake()->unique()->safeEmail(),
        ])->afterCreating(function (User $user) {
            $user->assignRole('siswa');
        });
    }

    /**
     * State untuk user dengan cabang tertentu
     */
    public function withCabang(int $cabangId): static
    {
        return $this->state(['cabang_id' => $cabangId]);
    }

    /**
     * Method untuk membuat user dengan role tertentu
     * Contoh penggunaan: User::factory()->withRole('editor')->create()
     *
     * @param string $role
     * @return static
     */
    public function withRole(string $role): static
    {
        if (!in_array($role, self::AVAILABLE_ROLES)) {
            throw new \InvalidArgumentException("Role '$role' tidak valid");
        }

        return $this->afterCreating(function (User $user) use ($role) {
            $user->assignRole($role);
        });
    }
}
