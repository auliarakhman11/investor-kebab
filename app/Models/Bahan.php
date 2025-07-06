<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bahan extends Model
{
    use HasFactory;

    protected $table = 'bahan';
    
    protected $fillable = ['bahan','satuan_id','aktif','jenis_bahan_id','possition','harga_beli'];

    public function satuan()
    {
        return $this->belongsTo(Satuan::class,'satuan_id','id');
    }
    public function jenisBahan()
    {
        return $this->belongsTo(JenisBahan::class,'jenis_bahan_id','id');
    }

    public function hargaBahan()
    {
        return $this->hasMany(HargaBahan::class,'bahan_id','id');
    }

    public function hargaBahanMitra()
    {
        return $this->hasMany(HargaBahanMitra::class,'bahan_id','id');
    }
}
