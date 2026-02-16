<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class SubjectsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();

        $subjects = DB::table('subjects')->select('id', 'name', 'category')->where('is_active', 1)->get();

        $byName = $subjects->keyBy('name');

        $umumNames = [
            'Bahasa Indonesia',
            'Pendidikan Agama dan Budi Pekerti (PABP)',
            'Pendidikan Pancasila',
            'Sejarah',
            'Pendidikan Jasmani, Olahraga, dan Kesehatan (PJOK)',
        ];

        $p5Name = 'Projek Penguatan Profil Pelajar Pancasila (P5)';

        $subjectIdsUmum = collect($umumNames)->map(fn ($n) => $byName[$n]->id ?? null)->filter()->values()->all();

        $subjectIdP5 = $byName[$p5Name]->id ?? null;

        $rows = [];

        $add = function (string $grade, array $subjectIds, ?int $majorId = null) use (&$rows, $now) {
            foreach ($subjectIds as $sid) {
                $rows[] = [
                    'major_id' => $majorId,
                    'grade_level' => $grade,
                    'subject_id' => $sid,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        };

        $add('X', $subjectIdsUmum, null);
        if ($subjectIdP5) $add('X', [$subjectIdP5], null);

        $add('XI', $subjectIdsUmum, null);

        $subjectIdsUmumXII = collect($subjectIdsUmum)->filter(function ($sid) use ($subjects) {
            $s = $subjects->firstWhere('id', $sid);
            return $s && $s->name !== 'Pendidikan Jasmani, Olahraga, dan Kesehatan (PJOK)';
            })->values()->all();

        $add('XII', $subjectIdsUmumXII, null);
        if ($subjectIdP5) $add('XII', [$subjectIdP5], null);

        DB::table('subject_offerings')->insertOrIgnore($rows);
    }
}