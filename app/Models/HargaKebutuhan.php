<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HargaKebutuhan extends Model
{
    use HasFactory;

    protected $table = 'harga_kebutuhan';
    protected $fillable = ['barang_kebutuhan_id','kota_id','harga','stok_baku'];

    public function barangKebutuhan()
    {
        return $this->belongsTo(BarangKebutuhan::class,'barang_kebutuhan_id','id');
    }
}
