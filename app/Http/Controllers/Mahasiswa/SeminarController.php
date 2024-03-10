<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Seminar;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class SeminarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $data = Seminar::select(['id', 'users_id', 'jenis', 'kegiatan', 'pelaksana', 'tempat', 'tanggal', 'tgl_selesai'])->where('users_id', Auth::user()->id)->orderBy('id', 'DESC')->get();
                    return DataTables::of($data)
                    ->addColumn('jenis', function($row) {
                        if ($row->jenis == 'nasional') {
                            $jn = 'Nasional';
                        } else {
                            $jn = 'Internasional';
                        }
                        return $jn;
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
                        return date('d-m-Y', strtotime($row->tanggal)) . ' - ' . date('d-m-Y', strtotime($row->tgl_selesai));
                    })
                    ->addColumn('action', function($row) {
                        $btn = '<a class="btn btn-info btn-sm mr-2" href="'.url('/portal/seminars/list/show/' . $row->id).'" data-id="'.$row->id.'" id="show"><i class="fas fa-eye"></i></a>';
                        $btn .= '<a class="btn btn-warning btn-sm mr-2" href="'.url('/portal/seminars/list/edit/' . $row->id).'" data-id="'.$row->id.'" id="edit"><i class="fas fa-pen"></i></a>';
                        $btn .= '<a class="btn btn-danger btn-sm" href="javascript:void(0)" data-id="'.$row->id.'" id="delete"><i class="fas fa-trash"></i></a>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->addIndexColumn()
                    ->toJson();
        }
        return view('mahasiswa.seminar.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('mahasiswa.seminar.create');
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
            'jenis' => 'required',
            'kegiatan' => 'required',
            'tanggal' => 'required',
            'tgl_selesai' => 'required',
            'tempat' => 'required',
            'docs' => 'required|mimes:pdf|max:10000',
            'sertifikat' => 'required|mimes:pdf|max:10000',
            'link' => 'required',
            'pelaksana' => 'required'
        ]);

        if ($request->status == 'Ada') {
            $docs = $request->file('docs');
            $docsName = date('dmy_H_i_s') . '.' . $docs->getClientOriginalExtension();
            $docs->storeAs('public/seminar/docs/', $docsName);

            $sertifikat = $request->file('sertifikat');
            $sertifikatName = date('dmy_H_i_s') . '.' . $sertifikat->getClientOriginalExtension();
            $sertifikat->storeAs('public/seminar/sertifikat/', $sertifikatName);

            $reward = $request->file('reward');
            $rewardName = date('dmy_H_i_s') . '.' . $reward->getClientOriginalExtension();
            $reward->storeAs('public/seminar/reward/', $rewardName);

            Seminar::create([
                'users_id' => Auth::user()->id,
                'jenis' => $request->jenis,
                'kegiatan' => $request->kegiatan,
                'tanggal' => $request->tanggal,
                'tempat' => $request->tempat,
                'docs' => $docsName,
                'sertifikat' => $sertifikatName,
                'link' => $request->link,
                'pelaksana' => $request->pelaksana,
                'tgl_selesai' => $request->tgl_selesai,
                'reward' => $rewardName,
                'status' => 'ada'
            ]);   
        } else {
            $docs = $request->file('docs');
            $docsName = date('dmy_H_i_s') . '.' . $docs->getClientOriginalExtension();
            $docs->storeAs('public/seminar/docs/', $docsName);

            $sertifikat = $request->file('sertifikat');
            $sertifikatName = date('dmy_H_i_s') . '.' . $sertifikat->getClientOriginalExtension();
            $sertifikat->storeAs('public/seminar/sertifikat/', $sertifikatName);

            Seminar::create([
                'users_id' => Auth::user()->id,
                'jenis' => $request->jenis,
                'kegiatan' => $request->kegiatan,
                'tanggal' => $request->tanggal,
                'tempat' => $request->tempat,
                'docs' => $docsName,
                'sertifikat' => $sertifikatName,
                'link' => $request->link,
                'keterangan' => $request->keterangan,
                'pelaksana' => $request->pelaksana,
                'tgl_selesai' => $request->tgl_selesai,
                'reward' => null,
                'status' => 'tidak'
            ]);   
        }
        return back()->with(['success' => 'Data Berhasil Disimpan']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Seminar::with('user')->find($id);
        return view('mahasiswa.seminar.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Seminar::find($id);
        return view('mahasiswa.seminar.edit', compact('data'));
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
        $request->validate([
            'jenis' => 'required',
            'kegiatan' => 'required',
            'tanggal' => 'required',
            'tgl_selesai' => 'required',
            'tempat' => 'required',
            'docs' => 'mimes:pdf|max:10000',
            'sertifikat' => 'mimes:pdf|max:10000',
            'link' => 'required',
            'pelaksana' => 'required'
        ]);

        $data = Seminar::find($id);
        if ($request->status == 'ada') {
            if ($request->hasFile('docs')) {
                $old_path_docs = public_path('storage/seminar/docs/' . $data->docs);
                unlink($old_path_docs);

                $docs = $request->file('docs');
                $docsName = date('dmy_H_i_s') . '.' . $docs->getClientOriginalExtension();
                $docs->storeAs('public/seminar/docs/', $docsName);

                $data->docs = $docsName;
            }

            if ($request->hasFile('sertifikat')) {
                $old_path_sertifikat = public_path('storage/seminar/sertifikat/' . $data->sertifikat);
                unlink($old_path_sertifikat);

                $sertifikat = $request->file('sertifikat');
                $sertifikatName = date('dmy_H_i_s') . '.' . $sertifikat->getClientOriginalExtension();
                $sertifikat->storeAs('public/seminar/sertifikat/', $sertifikatName);

                $data->sertifikat = $sertifikatName;
            }

            if ($request->hasFile('reward')) {
                if ($data->reward != null) {
                    $old_path_reward = public_path('storage/seminar/reward/' . $data->reward);
                    unlink($old_path_reward);
                }

                $reward = $request->file('reward');
                $rewardName = date('dmy_H_i_s') . '.' . $reward->getClientOriginalExtension();
                $reward->storeAs('public/seminar/reward/', $rewardName);

                $data->reward = $rewardName;
            }

            $data->jenis = $request->jenis;
            $data->kegiatan = $request->kegiatan;
            $data->tanggal = $request->tanggal;
            $data->tempat = $request->tempat;
            $data->link = $request->link;
            $data->pelaksana = $request->pelaksana;
            $data->tgl_selesai = $request->tgl_selesai;   
            $data->status = 'ada';
            $data->save();
        } else {
            if ($request->status == 'tidak') {
                $old_path_reward = public_path('storage/seminar/reward/' . $data->reward);
                unlink($old_path_reward);

                if ($request->hasFile('docs')) {
                    $old_path_docs = public_path('storage/seminar/docs/' . $data->docs);
                    unlink($old_path_docs);

                    $docs = $request->file('docs');
                    $docsName = date('dmy_H_i_s') . '.' . $docs->getClientOriginalExtension();
                    $docs->storeAs('public/seminar/docs/', $docsName);

                    $data->docs = $docsName;
                }

                if ($request->hasFile('sertifikat')) {
                    $old_path_sertifikat = public_path('storage/seminar/sertifikat/' . $data->sertifikat);
                    unlink($old_path_sertifikat);

                    $sertifikat = $request->file('sertifikat');
                    $sertifikatName = date('dmy_H_i_s') . '.' . $sertifikat->getClientOriginalExtension();
                    $sertifikat->storeAs('public/seminar/sertifikat/', $sertifikatName);

                    $data->sertifikat = $sertifikatName;
                }

                $data->jenis = $request->jenis;
                $data->kegiatan = $request->kegiatan;
                $data->tanggal = $request->tanggal;
                $data->tempat = $request->tempat;
                $data->link = $request->link;
                $data->pelaksana = $request->pelaksana;
                $data->tgl_selesai = $request->tgl_selesai;   
                $data->reward = null;
                $data->status = 'tidak';
                $data->save();
            } else {
                $data->jenis = $request->jenis;
                $data->kegiatan = $request->kegiatan;
                $data->tanggal = $request->tanggal;
                $data->tempat = $request->tempat;
                $data->link = $request->link;
                $data->pelaksana = $request->pelaksana;
                $data->tgl_selesai = $request->tgl_selesai;   
                $data->save();
            }
        }
        return redirect()->route('mhs.seminar.list')->with(['success' => 'Data Berhasil Diubah']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Seminar::find($id);
        $old_path_docs = public_path('storage/seminar/docs/' . $data->docs);
        $old_path_sertifikat = public_path('storage/seminar/sertifikat/' . $data->sertifikat);
        unlink($old_path_docs);
        unlink($old_path_sertifikat);
        $data->delete();
        return response()->json(200);
    }
}
