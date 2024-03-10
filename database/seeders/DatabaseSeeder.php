<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleSeeder::class);
        $userAdmin = User::create([
            'name' => 'Admin',
            'username' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password')
        ]);
        $userAdmin->assignRole('Admin');

        $userDosen = User::create([
            'name' => 'Dosen',
            'email' => 'dosen@gmail.com',
            'username' => '20221030002',
            'password' => Hash::make('password')
        ]);
        $userDosen->assignRole('Dosen');

        $userMhs = User::create([
            'name' => 'Mahasiswa',
            'username' => '20221040002',
            'password' => Hash::make('password')
        ]);
        $userMhs->assignRole('Mahasiswa');

        $this->call(IndikatorSeeder::class);
        $this->call(SemesterSeeder::class);
    }
}
