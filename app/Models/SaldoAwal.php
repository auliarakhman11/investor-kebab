<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaldoAwal extends Model
{
    use HasFactory;

    protected $table = 'saldo_awal';
    
    protected $fillable = ['cabang_id','bahan_baku_id','stok_awal','tgl','jenis_data','user_id'];
}
