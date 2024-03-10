<?php

namespace App\Http\Controllers;

use App\Models\LoogBook;
use App\Models\Report;
use App\Models\Seminar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index() {
        if (Auth::user()->roles[0]->name == 'Mahasiswa') {
            $logbookCount = LoogBook::count();
            $reportCount = Report::count();
            $seminarInternasionalCount = Seminar::where('jenis', '=', 'internasional')->count();
            $SeminarNasioanlCount = Seminar::where('jenis', '=', 'nasional')->count();
            return view('dashboard', compact('logbookCount', 'reportCount', 'seminarInternasionalCount', 'SeminarNasioanlCount'));
        } else {
            return view('dashboard');
        }
    }
}
