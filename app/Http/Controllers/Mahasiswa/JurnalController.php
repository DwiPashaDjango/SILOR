<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Jurnal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class JurnalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jurnalCount = Jurnal::where('users_id', Auth::user()->id)->count();
        if (request()->ajax()) {
            $data = Jurnal::where('users_id', Auth::user()->id)->orderBy('id', 'DESC')->get();
            return DataTables::of($data)
                    ->addColumn('title', function($row) {
                        return $row->title;
                    })
                    ->addColumn('file', function($row) {
                        return '<a href="'.asset('storage/jurnal/' . Auth::user()->name . '/' . $row->file).'" target="__blank" class="btn btn-primary btn-sm">Lihat Jurnal</a>';
                    })
                    ->addColumn('status', function($row) {
                        if ($row->status != 'pending') {
                            $st = '<span class="badge bg-success p-2 text-white">Approved</span>';
                        } else {
                            $st = '<span class="badge bg-warning p-2 text-white">Prosess</span>';
                        }
                        return $st;
                    })
                   ->rawColumns(['file', 'status'])
                   ->addIndexColumn() 
                   ->toJson();
        }
        return view('mahasiswa.jurnal.index', compact('jurnalCount'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('mahasiswa.jurnal.create');
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
            'title' => 'required|unique:jurnals',
            'abstrak' => 'required',
            'link' => 'required',
            'file' => 'required|mimes:pdf|max:10000'
        ]);

        $file = $request->file('file');
        $fileName = date('dmy_H_i_s') . '.' . $file->getClientOriginalExtension();
        $file->storeAs('public/jurnal/' . Auth::user()->name . '/', $fileName);

        Jurnal::create([
            'users_id' => Auth::user()->id,
            'title' => $request->title,
            'abstrak' => $request->abstrak,
            'link' => $request->link,
            'file' => $fileName,
            'status' => 'pending'
        ]);
        return back()->with(['success' => 'Data Berhasil Disimpan.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function paidJurnal()
    {
        $data = Jurnal::where('users_id', Auth::user()->id)->where('status', 'paid')->orderBy('id', 'DESC')->paginate(5);
        return view('mahasiswa.jurnal.paid', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Jurnal::find($id);
        return view('mahasiswa.jurnal.edit', compact('data'));
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
            'tanggal' => 'required',
            'ruangan' => 'required',
            'image' => 'required|mimes:png,jpeg,jpg',
        ]);

        $image = $request->file('image');
        $imageName = date('dmy_H_i_s') . '.' . $image->getClientOriginalExtension();
        $image->storeAs('public/jurnal/image/', $imageName);

        $data = Jurnal::find($id);
        $data->update([
            'tanggal' => $request->tanggal,
            'ruangan' => $request->ruangan,
            'image' => $imageName,
        ]);
        return back()->with(['success' => 'Berhasil Mengupload Kegiatan Baca Jurnal']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getJudul($title)
    {
        $data = Jurnal::where('title', $title)->get();
        return response()->json($data);
    }
}
