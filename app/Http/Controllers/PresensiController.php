<?php

namespace App\Http\Controllers;

use App\Models\Presensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PresensiController extends Controller
{
    public function presensi(){
        $today = date('Y-m-d');
        $id_karyawan = session('user')->id;
        $check = Presensi::query()->where('tgl_presensi', $today)->where('id_karyawan', $id_karyawan)->count();
        return view('user.presensi', ['check' => $check]);
    }

    public function addPresensi(Request $request){
        $id = session('user')->id;
        $nik = session('user')->nik;
        $tgl_presensi = date('Y-m-d');
        $jam = date('H:i:s');

        // validasi jarak
        $latitudeKantor = "-7.392515596262893";
        $longitudeKantor = "108.14699229105807";
        $lokasi = $request->lokasi;
        $lokasiUser = explode(',', $lokasi);
        $latitudeUser = $lokasiUser[0];
        $longitudeUser = $lokasiUser[1];

        $jarak = $this->distance($latitudeKantor, $longitudeKantor, $latitudeUser, $longitudeUser);
        $radius = round($jarak["meters"]);

        $check = Presensi::query()->where('tgl_presensi', $tgl_presensi)->where('id_karyawan', $id)->count();
        if($check > 0){
            $ket = 'in';
        } else {
            $ket = 'out';
        }
        $gambar = $request->image;
        $format_name = $nik . "-" . $tgl_presensi . "-" . $ket;
        $folder_path = "uploads/absensi/";
        $image_part = explode(';base64', $gambar);
        $image_64 = base64_decode($image_part[1]);
        $filename = $format_name . ".png";
        $file = $folder_path . $filename;
        $data = [
            'id_karyawan' => $id,
            'nik' => $nik,
            'tgl_presensi' => $tgl_presensi,
            'jam_in' => $jam,
            'foto_in' => $filename,
            'lokasi_in' => $lokasi,
        ];

        if($radius > 50.0){
            return response()->json(['status' => 'error', 'message' => 'Maaf Anda Berada DiLuar Radius Sekolah', 'type' => 'radius']);
        } else {
            if($check > 0) {
                $data = [
                    'jam_out' => $jam,
                    'foto_out' => $filename,
                    'lokasi_out' => $lokasi,
                ];
                $update = Presensi::query()->where('tgl_presensi', $tgl_presensi)->where('id_karyawan', $id)->update($data);
                if($update){
                    Storage::disk('public')->put($file, $image_64);
                    return response()->json(['status' => 'success', 'message' => 'Hati Hati Dijalan', 'type' => 'out']);
                } else {
                    return response()->json(['status' => 'error', 'message' => 'Absensi Gagal']);
                }
            } else {
                $simpan = Presensi::query()->create($data);
                if($simpan){
                    Storage::disk('public')->put($file, $image_64);
                    return response()->json(['status' => 'success', 'message' => 'Selamat Bekerja', 'type' => 'in']);
                } else {
                    return response()->json(['status' => 'error', 'message' => 'Absensi Gagal']);
                }
            }
        }
    }

    function distance($lat1, $lon1, $lat2, $lon2)
    {
        $theta = $lon1 - $lon2;
        $miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
        $miles = acos($miles);
        $miles = rad2deg($miles);
        $miles = $miles * 60 * 1.1515;
        $feet = $miles * 5280;
        $yards = $feet / 3;
        $kilometers = $miles * 1.609344;
        $meters = $kilometers * 1000;
        return compact('meters');
    }
}
