<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    protected $table = "presensi";
    protected $guarded = "id";
    protected $fillable = [
        'id_karyawan',
        'jam_in',
        'jam_out',
        'tgl_presensi',
        'foto_in',
        'foto_out',
        'lokasi_in',
        'lokasi_out'
    ];
}
