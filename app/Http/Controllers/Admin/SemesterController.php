<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PivotSemester;
use App\Models\Semester;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SemesterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $data = Semester::all();
            return DataTables::of($data)
            ->addColumn('name', function($row) {
                return $row->name;
            })
            ->addColumn('action', function($row) {
                $btn = '<a href="'.route('admin.semesters.show', ['id' => $row->id]).'" class="btn btn-primary btn-sm mr-2"><i class="fas fa-users"></i></a>';
                $btn .= '<a href="javascript:void(0)" data-id="'.$row->id.'" id="delete" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->toJson();
        }
        return view('admin.semester.index');
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
            'name' => 'required'
        ]);

        Semester::create([
            'name' => $request->name
        ]);
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
        $data = Semester::find($id);
        $mhs = User::doesntHave('semester')
                    ->whereHas('roles', function ($query) {
                        $query->where('name', 'Mahasiswa');
                    })
                    ->orderBy('id', 'DESC')
                    ->paginate(10);
        $semesters = Semester::all();
        if (request()->ajax()) {
            $type = request('type');

            if ($type === 'one') {
                $relation = PivotSemester::with('user')->where('semesters_id', $id);
                return DataTables::of($relation)
                ->addColumn('nim', function($row) {
                    return $row->user->username;
                })
                ->addColumn('name', function($row) {
                    return $row->user->name;
                })
                ->addColumn('action', function($row) {
                    $btn = '<a href="javascript:void(0)" data-id="'.$row->id.'" id="enroll" class="btn btn-warning btn-sm mr-2"><i class="fas fa-exchange-alt"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->toJson();
            } elseif($type === 'two') {
                $mhs = User::doesntHave('semester')
                    ->whereHas('roles', function ($query) {
                        $query->where('name', 'Mahasiswa');
                    })
                    ->orderBy('id', 'DESC')
                    ->get();
                return DataTables::of($mhs)
                ->addColumn('action', function($row) {
                    $act = '<input type="checkbox" name="users_id[]" id="users_id" value="'.$row->id.'">';
                    return $act;
                })
                ->addColumn('nim', function($row) {
                    return $row->username;
                })
                ->addColumn('name', function($row) {
                    return $row->name;
                })
                ->rawColumns(['action'])
                ->toJson();
            }
        }
        return view('admin.semester.show', compact('data', 'mhs', 'semesters'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = PivotSemester::find($id);
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function saveMhs(Request $request)
    {
        $users = $request->input('users_id');
        foreach ($users as $value) {
            PivotSemester::create([
                'semesters_id' => $request->semesters_id,
                'users_id' => $value
            ]);
        }
        return back()->with(['success' => 'Data Berhasil Disimpan']);
    }

    public function enrollSemester(Request $request, $id) {
        $data = PivotSemester::find($id);
        $data->update([
            'semesters_id' => $request->semesters_id
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
        $data = Semester::find($id);
        PivotSemester::where('semesters_id', $id)->delete();
        $data->delete();
        return response()->json(200);
    }
}
