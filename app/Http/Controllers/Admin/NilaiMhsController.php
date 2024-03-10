<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Matkul;
use App\Models\Nilai;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class NilaiMhsController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = User::find($id);
        $userId = $data->id;
        $matkul = Matkul::whereDoesntHave('nilai', function ($query) use ($userId) {
                            $query->where('users_id', $userId);
                        })
                        ->orderBy('id', 'DESC')
                        ->get();
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
                ->addColumn('action', function($row) {
                    $btn = '<a class="btn btn-danger btn-sm" href="javascript:void(0)" data-id="'.$row->id.'" id="delete"><i class="fas fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->toJson();
        }
        return view('admin.nilai.index', compact('data', 'matkul'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'matkuls_id' => 'required'
        ], [
            'matkuls_id.required' => 'Pilih Salah Satu Mata Kuliah Atau Lebih.'
        ]);

        $selectedMatkul = $request->input('matkuls_id');
        foreach ($selectedMatkul as $value) {
            Nilai::create([
                'users_id' => $request->users_id,
                'matkuls_id' => $value
            ]);
        }
        return back()->with(['success' => 'Berhasil Menambahkan Mata Kuliah Yang Diambil Oleh Mahasiswa.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Nilai::find($id);
        $data->delete();
        return response()->json(200);
    }
}
