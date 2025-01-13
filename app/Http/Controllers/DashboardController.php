<?php

namespace App\Http\Controllers;

use App\Models\Izin;
use App\Models\Presensi;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class DashboardController extends Controller
{
    public function index(){
        $today = date('Y-m-d');
        $tahunini = date('Y');
        $bulanini = date('m') * 1;
        $id_karyawan = session('user')->id;
        if(!$id_karyawan){
            Alert::error('Id Karayawan Tidak Ditemukan');
            return redirect()->back();
        }

        $namabulan = ["Januari", "Februrai", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

        $presensi = Presensi::query()->where('tgl_presensi', $today)->where('id_karyawan', $id_karyawan)->first();
        $rekapbulanini = Presensi::query()->whereRaw('MONTH(tgl_presensi)="' . $bulanini . '"')
                                ->whereRaw('YEAR(tgl_presensi)="' . $tahunini . '"')
                                ->orderBy('tgl_presensi')
                                ->get();

        $rekappresensi = Presensi::query()->selectRaw(
                                'COUNT(id_karyawan) AS jmlHadir,
                                 SUM(IF(jam_in > "07.00",1,0)) as jmlTerlambat'
                                )
                                ->where('id_karyawan', $id_karyawan)
                                ->whereRaw('MONTH(tgl_presensi)="' . $bulanini . '"')
                                ->whereRaw('YEAR(tgl_presensi)="' . $tahunini . '"')
                                ->orderBy('tgl_presensi')
                                ->first();

        $leaderBoard = Presensi::query()->join('karyawan', 'karyawan.id', '=', 'presensi.id_karyawan')
                                ->where('tgl_presensi', $today)->orderBy('jam_in')->get();
        $rekapizin = Izin::query()
                        ->selectRaw('SUM(IF(status="sakit",1,0)) as jmlSakit, SUM(IF(status="izin",1,0)) as jmlIzin')
                        ->where('id_karyawan', $id_karyawan)
                        ->whereRaw('MONTH(tgl_izin)="' . $bulanini . '"')
                        ->whereRaw('YEAR(tgl_izin)="' . $tahunini . '"')
                        ->where('status_approved', 'Sukses')
                        ->first();
        $data = [
            'presensi' => $presensi,
            'rekapbulan' => $rekapbulanini,
            'namabulan' => $namabulan,
            'rekappresensi' => $rekappresensi,
            'leaderBoard' => $leaderBoard,
            'rekapizin' => $rekapizin
        ];
        return view('user.dashboard', $data);
    }
}
