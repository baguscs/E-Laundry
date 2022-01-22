<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    public function pegawai()
    {
        return $this->belongsTo('App\Models\Pegawai', 'pegawai_id');
    }
}
