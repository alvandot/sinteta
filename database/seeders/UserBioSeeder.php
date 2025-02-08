<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UserBio;
use Faker\Factory;
use DB;

class UserBioSeeder extends Seeder
{
    private const AVAILABLE_GENDERS = ['L', 'P'];
    private const AVAILABLE_RELIGIONS = ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'];
    private const AVAILABLE_BLOOD_TYPES = ['A', 'B', 'AB', 'O'];
    private const AVAILABLE_SCHOOLS = [
        'SMAN 1',
        'SMAN 2',
        'SMAN 3',
        'SMAN 4',
        'SMAN 5',
        'SMAN 6',
        'SMAN 7',
        'SMAN 8',
        'SMAN 9',
        'SMAN 10'
    ];
    private const AVAILABLE_MAJORS = ['IPA', 'IPS', 'BAHASA'];
    private const AVAILABLE_CLASSES = ['X', 'XI', 'XII'];

    public function run()
    {
        $faker = Factory::create('id_ID');

        $this->command->info('Seeding user bio...');

        DB::transaction(function () use ($faker) {
            $users = User::all();

            foreach ($users as $user) {
                $this->createBioForUser($user, $faker);
            }
        });

        $this->command->info('Seeding user bio selesai!');
    }

    private function createBioForUser(User $user, $faker)
    {
        $this->command->info("Membuat bio untuk user {$user->name}...");

        $userBio = UserBio::create([
            'user_id' => $user->id,
            'phone_number' => $this->generatePhoneNumber($faker),
            'address' => $faker->address(),
            'birth_date' => $faker->dateTimeBetween('-30 years', '-15 years')->format('Y-m-d'),
            'gender' => $faker->randomElement(self::AVAILABLE_GENDERS),
            'avatar' => null,
            'nik' => $faker->numerify('################'),
            'nisn' => $faker->numerify('##########'),
            'school' => $faker->randomElement(self::AVAILABLE_SCHOOLS),
            'class' => $faker->randomElement(self::AVAILABLE_CLASSES),
            'major' => $faker->randomElement(self::AVAILABLE_MAJORS),
            'parent_name' => $faker->name(),
            'parent_phone' => $this->generatePhoneNumber($faker),
            'parent_address' => $faker->address(),
            'bio' => $faker->text(),
            'social_media' => json_encode([
                'facebook' => $faker->userName(),
                'twitter' => $faker->userName(),
                'instagram' => $faker->userName(),
            ]),
            'additional_info' => json_encode([
                'religion' => $faker->randomElement(self::AVAILABLE_RELIGIONS),
                'blood_type' => $faker->randomElement(self::AVAILABLE_BLOOD_TYPES),
                'birth_place' => $faker->city(),
            ]),
        ]);

        $this->command->info("Bio untuk user {$user->name} berhasil dibuat.");
    }

    private function generatePhoneNumber($faker)
    {
        $prefixes = ['0812', '0813', '0821', '0822', '0852', '0853', '0811', '0814'];
        $prefix = $faker->randomElement($prefixes);
        $number = $faker->numerify('########');
        return $prefix . $number;
    }
}
