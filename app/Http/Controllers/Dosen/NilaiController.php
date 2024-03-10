<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Indikator;
use App\Models\Nilai;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class NilaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         if (request()->ajax()) {
            $data = User::with('semester.semesterName')->whereHas('roles', function ($query) {
                        $query->where('name', 'Mahasiswa');
                    })->orderBy('id', 'DESC')->get();
            return DataTables::of($data)
                ->addColumn('name', function($row) {
                    return '<a href="'.url("/dosens/mahasiswas/" . $row->username).'">' . $row->name . '</a>';
                })
                ->addColumn('nim', function($row) {
                    return $row->nim;
                })
                ->addColumn('email', function($row) {
                    return $row->email;
                })
                ->addColumn('semester', function($row) {
                    if ($row->semester_count > 0) {
                        return $row->semester->semesterName->name;
                    } else {
                        return 'Belum Memiliki Semester';
                    }
                })
                ->rawColumns(['name'])
                ->addIndexColumn()
                ->toJson();
        }
        return view('dosen.nilai.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($username)
    {
        $data = User::select('id', 'name', 'username')->where('username', $username)->first();
        if (request()->ajax()) {
            $nilai = Nilai::with(['matkul'])->where('users_id', $data->id)->orderBy('id', 'DESC');
            return DataTables::of($nilai)
                ->addColumn('kd_matkul', function($row) {
                    return $row->matkul->kd_matkul;
                })
                ->addColumn('nm_matkul', function($row) {
                    return $row->matkul->nm_matkul;
                })
                ->addColumn('sks', function($row) {
                    return $row->matkul->sks;
                })
                ->addColumn('bobot', function($row) {
                    return $row->bobot;
                })
                ->addColumn('huruf', function($row) {
                    $indikator = Indikator::select('nilai_awal', 'nilai_akhir', 'huruf')->get();
                    foreach ($indikator as $value) {
                        if ($row->bobot >= $value->nilai_awal && $row->bobot <= $value->nilai_akhir) {
                            return $value->huruf;
                        }
                    }
                    return '';
                })
                ->addColumn('action', function($row) {
                    if ($row->bobot != null) {
                        if ($row->status == 'locked') {
                            $btn = '<a class="btn btn-warning btn-sm disabled" href="javascript:void(0)" id="edit"><i class="fas fa-pen"></i></a>';
                        } else {
                            $btn = '<a class="btn btn-info btn-sm mr-2" href="javascript:void(0)" data-id="'.$row->id.'" id="locked"><i class="fas fa-lock"></i></a>';
                            $btn .= '<a class="btn btn-warning btn-sm" href="javascript:void(0)" data-id="'.$row->id.'" id="edit"><i class="fas fa-pen"></i></a>';
                        }
                    } else {
                        $btn = '<a class="btn btn-primary btn-sm" href="javascript:void(0)" data-id="'.$row->id.'" id="add"><i class="fas fa-plus"></i></a>';
                    }
                    return $btn;
                })
                ->rawColumns(['action'])
                ->toJson();
        }
        return view('dosen.nilai.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(string $id)
    {
        $data = Nilai::with(['matkul'])->where('id', $id)->first();
        if (!$data) {
            return response()->json(['message' => 'Data not found'], 404);
        }
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function insertNilai(Request $request, $id)
    {
        $_rules = Validator::make($request->all(), [
            'bobot' => 'required'
        ], [
            'bobot.required' => 'Masukan Nilai Akhir Pada Mata Kuliah Ini.'
        ]); 

        if ($_rules->fails()) {
            return response()->json(['errors' => $_rules->errors()], 400);
        }

        $data = Nilai::find($id);
        $data->update([
            'bobot' => $request->bobot
        ]); 
        return response()->json(200);
    }

    public function lockNilai($id) {
        $data = Nilai::find($id);
        $data->update([
            'status' => 'locked'
        ]);
        return response()->json(200);
    }
}
