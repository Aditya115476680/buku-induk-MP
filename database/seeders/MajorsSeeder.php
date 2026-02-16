<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class MajorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();

        DB::table('majors')->upsert([
            [
                'code' => 'PPLG',
                'name' => 'Pengembangan Perangkat Lunak dan Gim',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'code' => 'DKV',
                'name' => 'Desain Komunikasi Visual',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ], ['code'], ['name', 'updated_at']);
    }
}
