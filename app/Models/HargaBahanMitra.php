<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HargaBahanMitra extends Model
{
    use HasFactory;

    protected $table = 'harga_bahan_mitra';
    protected $fillable = ['bahan_id','mitra_id','harga'];

    public function mitra()
    {
        return $this->belongsTo(Mitra::class,'mitra_id','id');
    }
}
