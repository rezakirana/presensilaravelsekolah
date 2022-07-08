<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PresensiDetail extends Model
{
    public function presensi()
    {
        return $this->belongsTo('App\Model\Presensi', 'presensi_id');
    }

    public function siswa()
    {
        return $this->belongsTo('App\Model\Siswa', 'siswa_id');
    }

}
