<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $data_login = [
            'nik' => $request->nik,
            'password' => $request->password
        ];

        $karyawan = Karyawan::query()->where('nik', $data_login['nik'])->first();
        if(!$karyawan){
            Alert::error('Nik Tidak Terdaftar');
            return redirect()->back();
        }

        if(!Hash::check($data_login['password'], $karyawan->password)){
            Alert::error('Password Salah');
            return redirect()->back();
        }
        if(!session()->isStarted())
            session()->start();
            session()->put('user', $karyawan);
            $session_lifetime = 60; // Durasi sesi dalam menit
            session()->put('expires_at', now()->addMinutes($session_lifetime));
            Alert::success('Berhasil Login');
            return redirect()->route('dashboard');


    }

    public function logout(){
        session()->flush();
        Alert::success('Berhasil Logout');
        return redirect()->route('login');
    }
}
