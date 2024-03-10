<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $type = request('type');

            if($type === 'normal') {
                $normalReport = Report::where('users_id', Auth::user()->id)->where('jenis', '=', 'normal')->get();
                return DataTables::of($normalReport)
                    ->addColumn('title', function($row) {
                        return $row->title;
                    })
                    ->addColumn('berkas', function($row) {
                        return '<a href="'.asset('storage/report/normal/' . $row->pdf_normal).'" target="__blank" class="btn btn-primary btn-sm">Lihat Berkas</a>';
                    })
                    ->addColumn('action', function($row) {
                        return '<a href="javascript:void(0)" id="deleteNormal" data-id="'.$row->id.'" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> </a>';
                    })
                    ->rawColumns(['berkas', 'action'])
                    ->addIndexColumn()
                    ->toJson();
            } elseif($type === 'presentase') {
                $presentaseReport = Report::where('users_id', Auth::user()->id)->where('jenis', '=', 'presentase')->get();
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
                    ->addColumn('action', function($row) {
                        return '<a href="javascript:void(0)" data-id="'.$row->id.'" id="deletePresentase" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> </a>';
                    })
                    ->rawColumns(['berkas', 'berkas_absensi', 'kegiatan', 'action'])
                    ->addIndexColumn()
                    ->toJson();
            }
        }
        return view('mahasiswa.report.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('mahasiswa.report.create');
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
            'title' => 'required',
            'pdf_normal' => 'required|mimes:pdf|max:10000'
        ]);

        $file = $request->file('pdf_normal');
        $fileName = date('dmy_H_i_s') . '.' . $file->getClientOriginalExtension();
        $file->storeAs('public/report/normal/', $fileName);

        Report::create([
            'users_id' => Auth::user()->id,
            'jenis' => 'normal',
            'title' => $request->title,
            'pdf_normal' => $fileName,
        ]);
        return back()->with(['success' => 'Data Berhasil Di Simpan.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function lapPresentase()
    {
        return view('mahasiswa.report.create_lap_presentase');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function insertLapPresentation(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'pdf_presentase' => 'required|mimes:pdf|max:10000',
            'pdf_absensi' => 'required|mimes:pdf|max:10000',
            'image_presentase' => 'required|mimes:png,jpg,jpeg|max:10000',
        ]);

        $filePdfPresentase = $request->file('pdf_presentase');
        $filePresnetaseName = date('dmy_H_i_s') . '.' . $filePdfPresentase->getClientOriginalExtension();
        $filePdfPresentase->storeAs('public/report/presentase/', $filePresnetaseName);

        $filePdfPresence = $request->file('pdf_absensi');
        $filePdfPresenceName = 'presence_' . date('dmy_H_i_s') . '.' . $filePdfPresence->getClientOriginalExtension();
        $filePdfPresence->storeAs('public/report/presentase/', $filePdfPresenceName);

        $image = $request->file('image_presentase');
        $imageName = date('dmy_H_i_s') . '.' . $image->getClientOriginalExtension();
        $image->storeAs('public/report/presentase/', $imageName);

        Report::create([
            'users_id' => Auth::user()->id,
            'jenis' => 'presentase',
            'title' => $request->title,
            'pdf_presentase' => $filePresnetaseName,
            'pdf_absensi' => $filePdfPresenceName,
            'image_presentase' => $imageName,
        ]);
        return back()->with(['success' => 'Data Berhasil Di Simpan.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Report::find($id);

        $type = request('type');
        if ($type === 'normal') {
            $old_path = public_path('storage/report/normal/' . $data->pdf_normal);
            unlink($old_path);
        } elseif($type === 'presentase') {
            $old_path = public_path('storage/report/presentase/' . $data->pdf_presentase);
            $old_path_absen = public_path('storage/report/presentase/' . $data->pdf_absensi);
            $old_path_image = public_path('storage/report/presentase/' . $data->image_presentase);
            unlink($old_path);
            unlink($old_path_absen);
            unlink($old_path_image);
        }
        $data->delete();
        return response()->json(200);
    }
}
