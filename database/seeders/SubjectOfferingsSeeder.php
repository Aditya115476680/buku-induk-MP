<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class SubjectOfferingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();

        $subjects = [
            ['name' => 'Bahasa Indonesia', 'category' => 'umum', 'is_active' => 1],
            ['name' => 'Pendidikan Agama dan Budi Pekerti (PABP)', 'category' => 'umum', 'is_active' => 1],
            ['name' => 'Pendidikan Pancasila', 'category' => 'umum', 'is_active' => 1],
            ['name' => 'Sejarah', 'category' => 'umum', 'is_active' => 1],
            ['name' => 'Pendidikan Jasmani, Olahraga, dan Kesehatan (PJOK)', 'category' => 'umum', 'is_active' => 1],
            ['name' => 'Projek Penguatan Profil Pelajar Pancasila (P5)', 'category' => 'p5', 'is_active' => 1],
        ];

        $payload = array_map(function ($s) use ($now) {
            return array_merge($s, ['created_at' => $now, 'updated_at' => $now]);
        }, $subjects);

        DB::table('subjects')->upsert(
            $payload,
            ['name', 'category'], ['is_active', 'updated_at']);
    }
}
