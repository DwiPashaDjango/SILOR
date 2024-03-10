<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Seminar;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class SeminarShowController extends Controller
{
    public function index() {
        if (request()->ajax()) {
            $data = User::with('semester.semesterName')->whereHas('roles', function ($query) {
                        $query->where('name', 'Mahasiswa');
                    })->orderBy('id', 'DESC')->get();
            return DataTables::of($data)
                    ->addColumn('name', function($row) {
                        return  '<a href="'.url('/dosens/seminars/show/' . $row->id).'">'.$row->name.'</a>';
                    })
                    ->addColumn('nim', function($row) {
                        return $row->username;
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
        return view('dosen.seminar.index');
    }

    public function show($id) {
        $data = User::find($id);
        if (request()->ajax()) {
            $data = Seminar::where('users_id', $id)->orderBy('id', 'DESC')->get();
                    return DataTables::of($data)
                    ->addColumn('jenis', function($row) {
                        if ($row->jenis == 'nasional') {
                            $jn = 'Nasional';
                        } else {
                            $jn = 'Internasional';
                        }
                        return $jn;
                    })
                    ->addColumn('name', function($row) {
                        return $row->user->name;
                    })
                    ->addColumn('kegiatan', function($row) {
                        return $row->kegiatan;
                    })
                    ->addColumn('pelaksana', function($row) {
                        return $row->pelaksana;
                    })
                    ->addColumn('tempat', function($row) {
                        return $row->tempat;
                    })
                    ->addColumn('tanggal', function($row) {
                        return Carbon::parse($row->tanggal)->translatedFormat('d F Y');
                    })
                    ->addColumn('action', function($row) {
                        $btn = '<a class="btn btn-info btn-sm mr-2" href="'.url('/dosens/seminars/show/files/' . $row->id).'" data-id="'.$row->id.'" id="show"><i class="fas fa-eye"></i></a>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->addIndexColumn()
                    ->toJson();
        }
        return view('dosen.seminar.show', compact('data'));
    }

    public function showFiles($id) {
        $data = Seminar::with('user')->find($id);
        return view('dosen.seminar.showFiles', compact('data'));
    }
}
