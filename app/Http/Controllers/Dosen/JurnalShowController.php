<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Jurnal;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class JurnalShowController extends Controller
{
    public function index() {
        if (request()->ajax()) {
            $data = User::with('semester.semesterName')->whereHas('roles', function ($query) {
                        $query->where('name', 'Mahasiswa');
                    })->orderBy('id', 'DESC')->get();
            return DataTables::of($data)
                ->addColumn('name', function($row) {
                    return '<a href="'.url("/dosens/jurnals/show/" . $row->id).'">' . $row->name . '</a>';
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
        return view('dosen.jurnal.index');
    }

    public function show($id) {
        $users = User::find($id);
        if (request()->ajax()) {
            $data = Jurnal::where('users_id', $id)->get();
            return DataTables::of($data)
                    ->addColumn('title', function($row) {
                        return $row->title;
                    })
                    ->addColumn('action', function($row) {
                        if ($row->status == 'paid') {
                            $btn = '<a href="'.url('/dosens/jurnals/reading/' . $row->id).'" class="btn btn-primary btn-sm">Lihat Jurnal</a>';
                        } else {
                            $btn = '<a href="javascript:void(0)" id="approved" data-id="'.$row->id.'" class="btn btn-success btn-sm mr-2">Approved Jurnal</a>';
                            $btn .= '<a href="'.url('/dosens/jurnals/reading/' . $row->id).'" class="btn btn-primary btn-sm">Lihat Jurnal</a>';
                        }
                        return $btn;
                    })
                   ->rawColumns(['action', 'status'])
                   ->addIndexColumn() 
                   ->toJson();
        }
        return view('dosen.jurnal.show', compact('users'));
    }

    public function readingJurnals($id) {
        $data = Jurnal::with('user')->where('id', $id)->first();
        return view('dosen.jurnal.reading', compact('data'));
    }

    public function approved($id) {
        $data = Jurnal::find($id);
        $data->update([
            'status' => 'paid'
        ]);
        return response()->json(200);
    }
}
