<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\MatkulImport;
use App\Models\Matkul;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class MatkulController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $data = Matkul::orderBy('id', 'DESC')->get();
            return DataTables::of($data)
                ->addColumn('kd_matkul', function($row) {
                    return $row->kd_matkul;
                })
                ->addColumn('nm_matkul', function($row) {
                    return $row->nm_matkul;
                })
                ->addColumn('sks', function($row) {
                    return $row->sks;
                })
                ->addColumn('action', function($row) {
                    $btn = '<div class="btn-group mb-2">
                                <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Pilih
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="javascript:void(0)" data-id="'.$row->id.'" id="edit">Edit</a>
                                    <a class="dropdown-item" href="javascript:void(0)" data-id="'.$row->id.'" id="delete">Hapus</a>
                                </div>
                            </div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->toJson();
        }
        return view('admin.matkul.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.matkul.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'kd_matkul' => 'required|unique:matkuls',
            'nm_matkul' => 'required',
            'sks' => 'required',
        ], [
            'kd_matkul.required' => 'Kode Mata Kuliah harus di isi.',
            'kd_matkul.unique' => 'Kode Mata Kuliah sudah terdaftar silahkan gunakan kode yang lain.',
            'nm_matkul.required' => 'Nama Mata Kuliah harus di isi.',
            'sks.required' => 'Jumlah SKS harus di isi.'
        ]);

        Matkul::create([
            'kd_matkul' => $request->kd_matkul,
            'nm_matkul' => $request->nm_matkul,
            'sks' => $request->sks,
        ]); 
        return redirect()->route('matkuls')->with(['success' => 'Data Mata Kuliah berhasil ditambahkan.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        $file = $request->file('file');

        $fileName = $file->hashName();

        $path = $file->storeAs('public/excel/', $fileName);

        $import = Excel::import(new MatkulImport(), storage_path('app/public/excel/' . $fileName));

        Storage::delete($path);

        if ($import) {
            return redirect()->route('matkuls')->with(['success' => 'Berhasil Mengimport Data Dosen']);
        } else {
            return redirect()->route('matkuls')->with(['error' => 'Gagal Mengimport Data Dosen']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Matkul::find($id);
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $__rules = Validator::make($request->all(), [
            'kd_matkul' => [
                'required',
                Rule::unique('matkuls')->ignore($id),
            ],
            'nm_matkul' => 'required',
            'sks' => 'required',
        ], [
            'kd_matkul.required' => 'Kode Mata Kuliah harus di isi.',
            'kd_matkul.unique' => 'Kode Mata Kuliah sudah terdaftar silahkan gunakan kode yang lain.',
            'nm_matkul.required' => 'Nama Mata Kuliah harus di isi.',
            'sks.required' => 'Jumlah SKS harus di isi.'
        ]);

        if ($__rules->fails()) {
            return response()->json(['errors' => $__rules->errors()], 400);
        }

        $data = Matkul::find($id);
        $data->update([
            'kd_matkul' => $request->kd_matkul,
            'nm_matkul' => $request->nm_matkul,
            'sks' => $request->sks,
        ]);
        return response()->json(200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Matkul::with('nilai')->find($id);
        $data->nilai()->delete();
        $data->delete();
        return response()->json(200);
    }
}
