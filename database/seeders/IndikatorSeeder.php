<?php

namespace Database\Seeders;

use App\Models\Indikator;
use Illuminate\Database\Seeder;

class IndikatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Indikator::create([
            'nilai_awal' => 40,
            'nilai_akhir' => 50,
            'huruf' => 'E'
        ]);

        Indikator::create([
            'nilai_awal' => 51,
            'nilai_akhir' => 60,
            'huruf' => 'D'
        ]);

        Indikator::create([
            'nilai_awal' => 61,
            'nilai_akhir' => 70,
            'huruf' => 'C'
        ]);

        Indikator::create([
            'nilai_awal' => 71,
            'nilai_akhir' => 80,
            'huruf' => 'B'
        ]);

        Indikator::create([
            'nilai_awal' => 81,
            'nilai_akhir' => 90,
            'huruf' => 'A'
        ]);

        Indikator::create([
            'nilai_awal' => 91,
            'nilai_akhir' => 100,
            'huruf' => 'A+'
        ]);
    }
}
