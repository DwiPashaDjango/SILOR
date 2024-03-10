<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Spatie\Permission\Models\Role;

class MahasiswaImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $key => $row) {
            if ($key === 0 || empty($row[1])) {
                continue; // Lewati baris pertama dan baris dengan 'kd_matkul' kosong
            }

            $existingUser = User::where('username', $row[2])->first();
            if ($existingUser) {
                session()->flash('error', 'NIM Dengan Nomor ' . $row[2] . ' sudah terdaftar. Data Tidak Dapat Di Masukan');
                continue;
            }

            $user = User::create([
                'name' => $row[1],
                'email' => $row[2],
                'username' => $row[3],
                'password' => Hash::make($row[4]),
            ]);

            $mhsRole = Role::where('name', 'Mahasiswa')->first();
            if ($mhsRole) {
                $user->assignRole($mhsRole);
            }
        }
    }
}
