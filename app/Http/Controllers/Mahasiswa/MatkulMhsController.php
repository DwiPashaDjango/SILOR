<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Indikator;
use App\Models\Nilai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class MatkulMhsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $data = Nilai::with(['matkul:id,kd_matkul,nm_matkul,sks'])
                        ->where('bobot', '!=', null)
                        ->where('users_id', Auth::user()->id)
                        ->orderBy('id', 'DESC');
            return DataTables::of($data)
                ->addColumn('kd_matkul', function($row) {
                    return $row->matkul->kd_matkul;
                })
                ->addColumn('nm_matkul', function($row) {
                    return $row->matkul->nm_matkul;
                })
                ->addColumn('sks', function($row) {
                    return $row->matkul->sks;
                })
                ->addColumn('nilai', function($row) {
                    return $row->bobot;
                })
                ->addColumn('huruf', function($row) {
                    $indikator = Indikator::select('nilai_awal', 'nilai_akhir', 'huruf')->get();
                    foreach ($indikator as $value) {
                        if ($row->bobot >= $value->nilai_awal && $row->bobot <= $value->nilai_akhir) {
                            return $value->huruf;
                        }
                    }
                    return 'Tidak ada nilai huruf yang cocok';
                })
                ->addIndexColumn()
                ->toJson();
        }
        return view('mahasiswa.nilai.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        if (request()->ajax()) {
            $data = Nilai::with(['matkul:id,kd_matkul,nm_matkul,sks'])->where('bobot', '=', null)->where('users_id', Auth::user()->id)->orderBy('id', 'DESC');
            return DataTables::of($data)
                ->addColumn('kd_matkul', function($row) {
                    return $row->matkul->kd_matkul;
                })
                ->addColumn('nm_matkul', function($row) {
                    return $row->matkul->nm_matkul;
                })
                ->addColumn('sks', function($row) {
                    return $row->matkul->sks;
                })
                ->addColumn('nilai', function($row) {
                    return $row->bobot;
                })
                ->addColumn('status', function($row) {
                    $st = '<span class="badge bg-primary m-2 text-white">Belum Lulus<span>';
                    return $st;
                })
                ->rawColumns(['status'])
                ->addIndexColumn()
                ->toJson();
        }
        return view('mahasiswa.nilai.show');
    }
}
