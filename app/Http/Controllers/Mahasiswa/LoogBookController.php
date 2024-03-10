<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\LogBookDetail;
use App\Models\LoogBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class LoogBookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $data = LoogBook::with('detail')->where('users_id', Auth::user()->id)->orderBy('id', 'DESC')->get();
            return DataTables::of($data)
                ->addColumn('no_medis', function($row) {
                    return $row->no_medis;
                })
                ->addColumn('kunjungan', function($row) {
                    return 'Kunjungan Ke - ' . $row->detail[0]->kunjungan;
                })
                ->addColumn('diagnosis', function($row) {
                    return $row->detail[0]->diagnosis;
                })
                ->addColumn('diagnosis_banding', function($row) {
                    return $row->detail[0]->diagnosis_banding;
                })
                ->addColumn('terapi', function($row) {
                    return $row->detail[0]->terapi;
                })
                ->addColumn('action', function($row) {
                    $btn = '<div class="btn-group mb-2">
                                <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Pilih
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="javascript:void(0)" data-id="'.$row->no_medis.'" id="detail">Detail Rekam Medis</a>
                                    <a class="dropdown-item" href="'.route('mhs.loogbook.edit', ['no_medis' => $row->no_medis]).'" id="edit">Edit</a>
                                    <a class="dropdown-item" href="javascript:void(0)" data-id="'.$row->id.'" id="delete">Hapus</a>
                                </div>
                            </div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->toJson();
        }
        return view('mahasiswa.loogbook.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('mahasiswa.loogbook.create');
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
            'no_medis' => 'required|min:8|max:8',
            'kunjungan' => 'required',
            'diagnosis' => 'required',
            'diagnosis_banding' => 'required',
            'terapi' => 'required',
        ], [
            'no_medis.required' => 'No Rekam Medis harus di isi.',
            'no_medis.unique' => 'No Rekam Medis sudah terdaftar silahkan gunakan yang lain.',
            'no_medis.min' => 'Minimal No Rekam Medis Adalah 8 Huruf & Characther.',
            'no_medis.max' => 'Maximal No Rekam Medis Adalah 8 Huruf & Characther.',
            'kunjungan.required' => 'Kunjungan harus di isi.',
            'diagnosis.required' => 'Diagnosis harus di isi.',
            'diagnosis_banding.required' => 'Diagnosis Banding harus di isi.',
            'terapi.required' => 'Terapi harus di isi.',
        ]);

        if ($request->status == 'available') {
            LogBookDetail::create([
                'no_medis' => $request->no_medis,
                'kunjungan' => $request->kunjungan,
                'diagnosis' => $request->diagnosis,
                'diagnosis_banding' => $request->diagnosis_banding,
                'terapi' => $request->terapi,
            ]);
        } else {
            LoogBook::create([
                'users_id' => Auth::user()->id,
                'no_medis' => $request->no_medis,
            ]);
    
            LogBookDetail::create([
                'no_medis' => $request->no_medis,
                'kunjungan' => $request->kunjungan,
                'diagnosis' => $request->diagnosis,
                'diagnosis_banding' => $request->diagnosis_banding,
                'terapi' => $request->terapi,
            ]);
        }

        return redirect()->route('mhs.loogbook')->with(['success' => 'Berhasil Menyimpan Data LoogBook.']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($no_medis)
    {
        $data = LoogBook::with('detail')->where('no_medis', $no_medis)->first();
        return view('mahasiswa.loogbook.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'kunjungan' => 'required|array',
            'diagnosis' => 'required|array',
            'diagnosis_banding' => 'required|array',
            'terapi' => 'required|array',
        ], [
            'kunjungan.required' => 'Kunjungan harus di isi.',
            'diagnosis.required' => 'Diagnosis harus di isi.',
            'diagnosis_banding.required' => 'Diagnosis Banding harus di isi.',
            'terapi.required' => 'Terapi harus di isi.',
        ]);

        foreach ($request->ids as $key => $id) {
            LogBookDetail::where('id', $id)->update([
                'kunjungan' => $request->kunjungan[$key],
                'diagnosis' => $request->diagnosis[$key],
                'diagnosis_banding' => $request->diagnosis_banding[$key],
                'terapi' => $request->terapi[$key],
            ]);
        }
        return redirect()->route('mhs.loogbook')->with(['success' => 'Berhasil Mengubah Data.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = LoogBook::find($id);
        $no_medis = $data->no_medis;
        LogBookDetail::where('no_medis', $no_medis)->delete();
        $data->delete();
        return response()->json(200);
    }

    public function getRekamMedis($no_medis) {
        $data = LoogBook::with(['detail'])->withCount('detail')->where('no_medis', $no_medis)->first();
        return response()->json($data);
    }
}
