<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Asesment;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AsesmentDosenController extends Controller
{
    public function index() {
        if (request()->ajax()) {
            $data = Asesment::orderBy('id', 'DESC')->get();
            return DataTables::of($data)
                   ->addColumn('title', function($row) {
                        return $row->title;
                   })
                   ->addColumn('action', function($row) {
                        $btn = '<a href="'.$row->url_dosen.'#responses" target="__blank" class="btn btn-primary btn-sm mr-2"><i class="fas fa-eye"></i></a>';
                        return $btn;
                   })
                   ->rawColumns(['action'])
                   ->addIndexColumn()
                   ->toJson();
        }
        return view('dosen.asesment.index');
    }
}
