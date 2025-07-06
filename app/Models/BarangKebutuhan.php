<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangKebutuhan extends Model
{
    use HasFactory;

    protected $table = 'barang_kebutuhan';
    protected $fillable = ['satuan_id','nm_barang','aktif','harga','harga_beli'];

    public function satuan()
    {
        return $this->belongsTo(Satuan::class,'satuan_id','id');
    }

    public function hargaKebutuhan()
    {
        return $this->hasMany(HargaKebutuhan::class,'barang_kebutuhan_id','id');
    }

    public function hargaKebutuhanMitra()
    {
        return $this->hasMany(HargaKebutuhanMitra::class,'barang_kebutuhan_id','id');
    }
}
