<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kota extends Model
{
    use HasFactory;

    protected $table = 'kota';
    protected $fillable = ['nm_kota'];

    public function cabang()
    {
        return $this->hasMany(Cabang::class,'kota_id','id');
    }

    public function hargaPengeluaran()
    {
        return $this->hasMany(HargaPengeluaran::class,'kota_id','id');
    }
}
