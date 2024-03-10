<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Asesment;
use App\Models\AsesmentUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class AsesmentShowController extends Controller
{
    public function index() {
        if (request()->ajax()) {
            $data = Asesment::with(['asesment_user'])->orderBy('id', 'DESC')->get();
            return DataTables::of($data)
                   ->addColumn('title', function($row) {
                        return $row->title;
                   })
                   ->addColumn('action', function($row) {
                        if ($row->asesment_user->contains('users_id', Auth::user()->id)) {
                            return '<a href="javascript:void(0)" class="btn btn-success btn-sm disabled">Selesai</a>';
                        } else {
                            return '<a href="javascript:void(0)" data-url="'.url('/portal/asesments/list/show/' . $row->slug).'" data-id="'.$row->id.'" id="apply" class="btn btn-primary btn-sm">Kerjakan</a>';
                        }
                    })
                   ->rawColumns(['action'])
                   ->addIndexColumn()
                   ->toJson();
        }
        return view('mahasiswa.asesment.index');   
    }

    public function show($slug) {
        $data = Asesment::where('slug', $slug)->first();
        return view('mahasiswa.asesment.show', compact('data'));
    }

    public function storeAsesment(Request $request) {
        AsesmentUsers::create([
            'users_id' => Auth::user()->id,
            'asesments_id' => $request->asesments_id
        ]); 
        return response()->json(200);
    }
}
