<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class ForgotPassword extends Controller
{
    public function index() {
        return view('auth.forgot');
    }

    public function forgot(Request $request) {
        $request->validate([
            'email' => 'required|email'
        ]);

        $token = Str::random(20);
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token
        ]);
        return redirect()->route('reset.new', ['token' => $token]);
    }

    public function reset($token) {
        $data = DB::table('password_resets')->where('token', $token)->first();
        return view('auth.reset', compact('data'));
    }

    public function newPassword(Request $request) {
        $request->validate([
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();
        if ($user) {
            $user->update([
                'password' => Hash::make($request->password)
            ]);
            DB::table('password_resets')->where('email', $request->email)->delete();
            Auth::logout();
            Session::flush();
            return redirect()->route('login')->with(['success' => 'Berhasil Mereset Password Silahkan Login Ulang']);
        } else {
            DB::table('password_resets')->where('email', $request->email)->delete();
            return redirect()->route('reset.index')->with(['success' => 'Gagal Mereset Password']); 
        }
    }
}
