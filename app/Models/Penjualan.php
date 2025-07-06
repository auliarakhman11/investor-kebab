<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

    protected $table = 'penjualan';
    protected $fillable = ['void','admin'];

    public function getMenu()
    {
        return $this->belongsTo(Produk::class,'produk_id','id');
    }

    public function penjualanVarian()
    {
        return $this->hasMany(PenjualanVarianOnline::class,'penjualan_id','id');
    }
}
