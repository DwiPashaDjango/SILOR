<?php

namespace App\Imports;

use App\Models\Matkul;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;

class MatkulImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $key => $row) {
            if ($key === 0 || empty($row[1])) {
                continue; // Lewati baris pertama dan baris dengan 'kd_matkul' kosong
            }

            $existingMatkul = Matkul::where('kd_matkul', $row[1])->first();
            if ($existingMatkul) {
                session()->flash('error', 'Kode Mata Kuliah Dengan Kode ' . $row[1] . ' sudah terdaftar. Data Tidak Dapat Di Masukkan');
                break;
            }

            $data = [
                'kd_matkul' => $row[1],
                'nm_matkul' => $row[2],
                'sks' => $row[3],
            ];
            DB::table('matkuls')->insert($data);
        }
    }
}
