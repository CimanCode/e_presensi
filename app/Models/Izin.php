<?php

namespace App\Models;

use App\Models\Karyawan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Izin extends Model
{
    use HasFactory, Notifiable;

    protected $table = "izin";
    protected $guarded = "id";
    protected $fillable = [
        'id_karyawan',
        'tgl_izin',
        'status',
        'keterangan',
        'status_approved',
    ];

    public function karyawan(): HasOne
    {
        return $this->hasOne(Karyawan::class);
    }


}
