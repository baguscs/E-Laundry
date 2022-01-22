<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->HasOne('App\Models\User');
    }

    public function role()
    {
        return $this->belongsTo('App\Models\Role', 'role_id');
    }

    public function barang()
    {
        return $this->hasOne('App\Models\Barang');
    }

    public function order()
    {
        return $this->hasOne('App\Models\Order');
    }

}
