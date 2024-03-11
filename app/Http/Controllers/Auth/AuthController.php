<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('auth.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' =>'required',
            'password' => 'required|min:8'
        ], [
            'username.required' => 'Masukan Nim/Nip',
            'password.required' => 'Masukan Password',
            'password.min' => 'Minimal Password 8 Huruf/Angka',
        ]);

        $user = User::where('username', $request->username)->orWhere('email', $request->username)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                Auth::login($user);
                if ($user->hasRole('Admin')) {
                    return redirect()->route('dashboard');
                } elseif($user->hasRole('Dosen')) {
                    return redirect()->route('dashboard');
                } else {
                    return redirect()->route('dashboard');
                }
            } else {
                return back()->with(['message' => 'Nim/Nip Atau Password Salah.']);
            }
        } else {
            return back()->with(['message' => 'Akun Tidak Terdaftar.']);
        }
    }

    public function logout() {
        Auth::logout();
        Session::flush();
        return redirect()->route('login');
    }
}
