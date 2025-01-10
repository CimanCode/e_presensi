<?php

namespace Database\Seeders;

use App\Models\Karyawan;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KaryawanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Karyawan::create([
            'nik' => '3206130809020001',
            'nama_lengkap' => 'Firman Abdul Rohman',
            'jabatan' => 'Engineer',
            'no_hp' => '085790638949',
            'password' => bcrypt('smkalfalahtjy')
        ]);
    }
}
