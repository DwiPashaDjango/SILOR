<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Indikator;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class IndikatorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $data = Indikator::orderBy('id', 'ASC')->get();
            return DataTables::of($data)
                ->addColumn('nilai_awal', function($row) {
                    return $row->nilai_awal;
                })
                ->addColumn('nilai_akhir', function($row) {
                    return $row->nilai_akhir;
                })
                ->addColumn('huruf', function($row) {
                    return $row->huruf;
                })
                ->addColumn('action', function($row) {
                    $btn = '<button class="btn btn-danger btn-sm" id="delete" data-id="'.$row->id.'"><i class="fas fa-trash"></i></button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->toJson();
        }
        return view('admin.indikator.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.indikator.create');
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
            'nilai_awal' => 'required',
            'nilai_akhir' => 'required',
            'huruf' => 'required',
        ]);

        Indikator::create([
            'nilai_awal' => $request->nilai_awal,
            'nilai_akhir' => $request->nilai_akhir,
            'huruf' => $request->huruf,
        ]);
        return redirect()->route('indikators')->with(['success' => 'Berhasil Menambahkan Data Indikator Nilai Baru.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Indikator::find($id);
        $data->delete();
        return response()->json(200);
    }
}
