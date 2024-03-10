<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Asesment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Js;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class AsesmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $data = Asesment::orderBy('id', 'DESC')->get();
            return DataTables::of($data)
                   ->addColumn('title', function($row) {
                        return $row->title;
                   })
                   ->addColumn('action', function($row) {
                        $btn = '<a href="'.$row->url_dosen.'#responses" target="__blank" class="btn btn-primary btn-sm mr-2"><i class="fas fa-eye"></i></a>';
                        $btn .= '<a href="javascript:void(0)" id="edit" data-id="'.$row->id.'" class="btn btn-warning btn-sm mr-2"><i class="fas fa-pen"></i></a>';
                        $btn .= '<a href="javascript:void(0)" id="delete" data-id="'.$row->id.'" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>';
                        return $btn;
                   })
                   ->rawColumns(['action'])
                   ->addIndexColumn()
                   ->toJson();
        }
        return view('admin.asesment.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.asesment.create');
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
            'url' => 'required',
            'url_dosen' => 'required'
        ]);

        $cleanUrl = str_replace('/viewform?usp=sf_link', '', $request->url);

        Asesment::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'url' => $cleanUrl,
            'url_dosen' => $request->url_dosen
        ]);
        return redirect()->route('admin.asesments')->with(['success' => 'Data Berhasil Disimpan.']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Asesment::find($id);
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
            'title' => 'required',
            'url' => 'required',
            'url_dosen' => 'required'
        ]);

        if ($__rules->fails()) {
            return response()->json(['errors' => $__rules->errors()]);
        }

        $cleanUrl = str_replace('/viewform?usp=sf_link', '', $request->url);

        $data = Asesment::find($id);
        $data->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'url' => $cleanUrl,
            'url_dosen' => $request->url_dosen
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
        $data = Asesment::find($id);
        $data->delete();
        return response()->json(200);
    }
}
