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
        'pekerjaan', 'tipe', 'ayah', 'ibu', 'id_keluarga',
        'id_user', 'validated'
    ];

    public function user(){
        return $this->belongsTo(User::class, "id_user");
    }

    public function keluarga(){
        return $this->belongsTo(Keluarga::class, "id_keluarga");
    }

    public function validasi(){
        return $this->hasMany(Validasi::class, "id_anggota");
    }
}
