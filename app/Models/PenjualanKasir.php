<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenjualanKasir extends Model
{
    use HasFactory;
    protected $table = 'penjualan_kasir';
    protected $fillable = ['void'];

    public function produk()
    {
        return $this->belongsTo(Produk::class,'produk_id','id');
    }
}
