<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HargaKebutuhanMitra extends Model
{
    use HasFactory;

    protected $table = 'harga_kebutuhan_mitra';
    protected $fillable = ['barang_kebutuhan_id','mitra_id','harga'];

    public function barangKebutuhan()
    {
        return $this->belongsTo(BarangKebutuhan::class,'barang_kebutuhan_id','id');
    }
}
