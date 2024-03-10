<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Spatie\Permission\Models\Role;

class DosenImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $key => $row) {
            if ($key === 0) {
                continue;
            }

            $existingUser = User::where('username', $row[2])->first();
            if ($existingUser) {
                session()->flash('error', 'NIP Dengan Nomor ' . $row[2] . ' sudah terdaftar. Data Tidak Dapat Di Masukan');
                continue;
            }

            $user = User::create([
                'name' => $row[1],
                'email' => $row[2],
                'username' => $row[3],
                'password' => Hash::make($row[4]),
            ]);

            $dosenRole = Role::where('name', 'Dosen')->first();
            if ($dosenRole) {
                $user->assignRole($dosenRole);
            }
        }
    }
}
