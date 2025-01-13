<?php

namespace App\Models;

use App\Models\Izin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Karyawan extends Model
{
    use HasFactory, Notifiable;

    protected $table = "karyawan";
    protected $guarded = "id";
    protected $fillable = [
        'nik',
        'nama_lengkap',
        'jabatan',
        'no_hp',
        'password',
        'foto',
        'remember_token'
    ];

    public function izin(): HasOne
    {
        return $this->hasOne(Izin::class);
    }
}
