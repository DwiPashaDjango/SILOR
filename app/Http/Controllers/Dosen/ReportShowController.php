<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class ReportShowController extends Controller
{
    public function index() {
        if (request()->ajax()) {
            $data = User::with('semester.semesterName')->whereHas('roles', function ($query) {
                        $query->where('name', 'Mahasiswa');
                    })->orderBy('id', 'DESC')->get();
            return DataTables::of($data)
                    ->addColumn('name', function($row) {
                        return  '<a href="'.url('/dosens/reports/show/' . $row->id).'">'.$row->name.'</a>';
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
        return view('dosen.report.index');
    }

    public function show($id) {
        $data = User::find($id);
        if (request()->ajax()) {
            $type = request('type');

            if($type === 'normal') {
                $normalReport = Report::where('users_id', $id)->where('jenis', '=', 'normal')->get();
                return DataTables::of($normalReport)
                    ->addColumn('title', function($row) {
                        return $row->title;
                    })
                    ->addColumn('berkas', function($row) {
                        return '<a href="'.asset('storage/report/normal/' . $row->pdf_normal).'" target="__blank" class="btn btn-primary btn-sm">Lihat Berkas</a>';
                    })
                    ->rawColumns(['berkas'])
                    ->addIndexColumn()
                    ->toJson();
            } elseif($type === 'presentase') {
                $presentaseReport = Report::where('users_id', $id)->where('jenis', '=', 'presentase')->get();
                return DataTables::of($presentaseReport)
                    ->addColumn('title', function($row) {
                        return $row->title;
                    })
                    ->addColumn('berkas', function($row) {
                        return '<a href="'.asset('storage/report/presentase/' . $row->pdf_presentase).'" target="__blank" class="btn btn-primary btn-sm">Lihat Berkas</a>';
                    })
                    ->addColumn('berkas_absensi', function($row) {
                        return '<a href="'.asset('storage/report/presentase/' . $row->pdf_absensi).'" target="__blank" class="btn btn-primary btn-sm">Lihat Berkas Absensi</a>';
                    })
                    ->addColumn('kegiatan', function($row) {
                        return '<a href="'.asset('storage/report/presentase/' . $row->image_presentase).'" target="__blank" class="btn btn-primary btn-sm">Lihat Foto Kegiatan</a>';
                    })
                    ->rawColumns(['berkas', 'berkas_absensi', 'kegiatan'])
                    ->addIndexColumn()
                    ->toJson();
            }
        }
        return view('dosen.report.show', compact('data'));
    }
}
