<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            MajorsSeeder::class,
            SubjectOfferingsSeeder::class,
            SubjectsSeeder::class,
            RolesAndAdminSeeder::class,
        ]);
    }
}
