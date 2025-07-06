<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HargaVarianMitra extends Model
{
    use HasFactory;

    protected $table = 'harga_varian_mitra';
    protected $fillable = ['varian_id','mitra_id','harga'];

    public function mitra()
    {
        return $this->belongsTo(Mitra::class,'mitra_id','id');
    }
}
