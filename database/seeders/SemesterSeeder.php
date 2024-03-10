<?php

namespace Database\Seeders;

use App\Models\Semester;
use Illuminate\Database\Seeder;

class SemesterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1; $i <= 7 ; $i++) { 
            Semester::create([
                'name' => 'Semester ' . $i
            ]);
        }
    }
}
