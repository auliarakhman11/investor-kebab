<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KasBarang extends Model
{
    use HasFactory;

    protected $table = 'kas_barang';
    protected $fillable = ['kd_gabungan','kota_id','bahan_id','varian_id','barang_id','kas','tgl','user_id'];
}
