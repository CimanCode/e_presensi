<?php

namespace App\Http\Controllers;

use App\Models\Izin;
use App\Models\Karyawan;
use App\Models\Presensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

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

    public function EditProfile(){
        $id_karyawan = session('user')->id;
        $karyawan = Karyawan::query()->where('id', $id_karyawan)->first();
        $data = [
            'karyawan' => $karyawan
        ];
        return view('user.profile', $data);
    }

    public function updateProfile(Request $request){
        $id_karyawan = $request->get('id_karyawan');
        if(!$id_karyawan){
            Alert::error('Id Tidak Ditemukan');
            return redirect()->back();
        }
        $nik = session('user')->nik;
        $nama_lengkap = $request->nama_lengkap;
        $no_hp = $request->no_hp;
        $jabatan = $request->jabatan;
        $password = Hash::make($request->password);
        $karyawanData = Karyawan::query()->where('id', $id_karyawan)->first();
        if(!empty($password)){
            $data = [
                'nama_lengkap' => $nama_lengkap,
                'no_hp' => $no_hp,
                'jabatan' => $jabatan,
            ];
        } else {
            $data = [
                'nama_lengkap' => $nama_lengkap,
                'no_hp' => $no_hp,
                'jabatan' => $jabatan,
                'password' => $password
            ];
        }

        if($request->hasFile('foto')){
            $file = $request->file('foto')->getClientOriginalExtension();
            $foto = $nik. "." . $file;
            $folder_path = "uploads/karyawan/";
            Storage::disk('public')->putFIleAs($folder_path, $request->file('foto'), $foto);
            $data['foto'] = $foto;
        } else {
            $foto = $karyawanData->foto;
        }
        $isUpdated = Karyawan::query()->where('id', $id_karyawan)->update($data);
        if($isUpdated){
            session()->put('user', $isUpdated);
            Alert::success('Profile Berhasil Diupdate');
            return redirect()->back();
        } else {
            return redirect()->back();
        }

    }

    public function histori(){
        $namabulan = ["", "Januari", "Februrai", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        $data = [
            'namabulan' => $namabulan,
        ];
        return view('user.histori', $data);
    }

    public function getHistory(Request $request){
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $id_karyawan = session('user')->id;
        $histori = Presensi::query()->whereRaw('MONTH(tgl_presensi)="' . $bulan . '"')
                            ->whereRaw('YEAR(tgl_presensi)="' . $tahun . '"')
                            ->where('id_karyawan', $id_karyawan)
                            ->orderBy('tgl_presensi')
                            ->get();

        $data = [
            'histori' => $histori
        ];

        return view('user.getHistory', $data);
    }

    public function izin(){
        $id_karyawan = session('user')->id;
        $izin = Izin::query()->where('id_karyawan', $id_karyawan)->get();
        $data = [
            'izin' => $izin
        ];
        return view('user.izin', $data);
    }

    public function buatIzin(){
        return view('user.buatIzin');
    }

    public function prosesIzin(Request $request){
        $id_karyawan = session('user')->id;
        $rules = [
            'tgl_izin' => 'required',
            'status' => 'required',
            'keterangan' => 'required',
        ];

        $message = [
            'tgl_izin.required' =>  'Tanggal Izin Harus Diisi',
            'status.required' => 'Status Izin/Sakit Harus Diisi',
            'keterangan.required' => 'Keterangan Harus Diisi',
        ];

        $validator = Validator::make($request->all(), $rules, $message);
        if($validator->fails()) {
            $error = implode(', ', array_map('implode', array_values($validator->errors()->messages())));
            Alert::error($error);
            return redirect()->back();
        }
        $data = $validator->validate();
        $data['id_karyawan'] = $id_karyawan;
        $data['status_approved'] = 'Pending';
        Izin::query()->create($data);
        Alert::success('Data Berhasil Dikirm');
        return redirect()->route('izin');
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
