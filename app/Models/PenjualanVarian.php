<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenjualanVarian extends Model
{
    use HasFactory;

    protected $table = 'penjualan_varian';
    protected $fillable = ['penujualan_id','no_invoive','varian_id','qty','harga','tgl'];

    public function varian()
    {
        return $this->belongsTo(Varian::class,'varian_id','id');
    }

}
