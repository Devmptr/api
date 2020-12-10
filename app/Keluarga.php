<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Keluarga extends Model
{
    //
    protected $table = 'keluarga';

    protected $fillable = [
        'nomor', 'alamat', 'rtrw', 'kodepos', 'kelurahan',
        'kecamatan', 'kabupaten', 'provinsi'
    ];

    public function anggota(){
        return $this->hasMany(AnggotaKeluarga::class, "id_keluarga");
    }
}
