<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Varian extends Model
{
    use HasFactory;
    protected $table = 'varian';
    protected $fillable = ['nm_varian','kategori_varian_id','harga','harga_beli','harga_beli'];

    public function kategori_varian()
    {
        return $this->belongsTo(KategoriVarian::class,'kategori_varian_id','id');
    }

    public function hargaVarian()
    {
        return $this->hasMany(HargaVarian::class,'varian_id','id');
    }

    public function hargaVarianMitra()
    {
        return $this->hasMany(HargaVarianMitra::class,'varian_id','id');
    }
}
