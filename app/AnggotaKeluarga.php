<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnggotaKeluarga extends Model
{
    //
    protected $table = 'anggota_keluarga';

    protected $fillable = [
        'nama', 'nik', 'jenis_kelamin', 'tempat_lahir', 
        'tanggal_lahir', 'agama', 'pendidikan',
        'pekerjaan', 'tipe', 'ayah', 'ibu'
    ];
}
