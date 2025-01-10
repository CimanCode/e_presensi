<?php

namespace App\Http\Controllers;

use App\Models\Presensi;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class DashboardController extends Controller
{
    public function index(){
        $today = date('Y-m-d');
        $tahunini = date('Y');
        $bulanini = date('m');
        $id_karyawan = session('user')->id;
        if(!$id_karyawan){
            Alert::error('Id Karayawan Tidak Ditemukan');
            return redirect()->back();
        }
        $presensi = Presensi::query()->where('tgl_presensi', $today)->where('id_karyawan', $id_karyawan)->first();
        $rekapbulanini = Presensi::query()->whereRaw('MONTH(tgl_presensi)="' . $bulanini . '"')
                                ->whereRaw('YEAR(tgl_presensi)="' . $tahunini . '"')
                                ->orderBy('tgl_presensi')
                                ->get();
        $data = [
            'presensi' => $presensi,
            'rekapbulan' => $rekapbulanini
        ];
        return view('user.dashboard', $data);
    }
}
