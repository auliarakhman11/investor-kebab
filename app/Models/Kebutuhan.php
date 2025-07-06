<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kebutuhan extends Model
{
    use HasFactory;

    protected $table = 'kebutuhan';
    protected $fillable = ['buka_toko_id','barang_kebutuhan_id','qty'];

    public function barangKebutuhan()
    {
        return $this->belongsTo(BarangKebutuhan::class,'barang_kebutuhan_id','id');
    }

    public function bukaToko()
    {
        return $this->belongsTo(bukaToko::class,'buka_toko_id','id');
    }
}
