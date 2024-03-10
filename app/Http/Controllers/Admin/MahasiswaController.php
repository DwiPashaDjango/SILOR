<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\MahasiswaImport;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $data = User::with('semester.semesterName')->withCount('semester')->whereHas('roles', function ($query) {
                        $query->where('name', 'Mahasiswa');
                    })->orderBy('id', 'DESC')->get();
            return DataTables::of($data)
                ->addColumn('name', function($row) {
                    return  '<a href="'.url('/admin/nilais/' . $row->id).'">'.$row->name.'</a>';
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
                ->rawColumns(['action', 'name'])
                ->addIndexColumn()
                ->toJson();
        }
        return view('admin.mahasiswa.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
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

        $import = Excel::import(new MahasiswaImport(), storage_path('app/public/excel/' . $fileName));

        Storage::delete($path);

        if ($import) {
            return redirect()->route('mhs')->with(['success' => 'Berhasil Mengimport Data Dosen']);
        } else {
            return redirect()->route('mhs')->with(['error' => 'Gagal Mengimport Data Dosen']);
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
        $data = User::find($id);
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
            'name' => 'required',
            'username' => [
                'required',
                Rule::unique('users')->ignore($id),
            ],
            'email' => [
                'required',
                Rule::unique('users')->ignore($id),
            ],
        ], [
            'name.required' => 'Nama Lengkap Mahasiswa harus di isi',
            'username.required' => 'Nomor Induk Mahasiswa harus di isi',
            'email.required' => 'Email Mahasiswa harus di isi',
            'username.unique' => 'Nomor Induk Mahasiswa sudah terdaftar silahkan gunakan yang lain.',
            'email.unique' => 'Email sudah terdaftar silahkan ginakan yang lain.'
        ]);

        if ($__rules->fails()) {
            return response()->json(['errors' => $__rules->errors()], 422);
        }

        $data = User::find($id);
        $data->update([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
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
        $data = User::with('nilai')->find($id);
        $data->nilai()->delete();
        $data->delete();
        return response()->json(200);
    }
}
