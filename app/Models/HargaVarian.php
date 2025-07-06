<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HargaVarian extends Model
{
    use HasFactory;

    protected $table = 'harga_varian';
    protected $fillable = ['varian_id','kota_id','harga','stok_baku'];

    public function kota()
    {
        return $this->belongsTo(Kota::class,'kota_id','id');
    }
}
