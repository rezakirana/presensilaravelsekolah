<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    public function presensi_details()
    {
        return $this->hasMany('App\Model\PresensiDetail', 'presensi_id');
    }

    public function jadwal()
    {
        return $this->belongsTo('App\Model\Jadwal', 'jadwal_id');
    }

}
