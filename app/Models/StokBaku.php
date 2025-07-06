<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokBaku extends Model
{
    use HasFactory;

    protected $table = 'stok_baku';
    protected $fillable = ['cabang_id','bahan_baku_id','stok_baku','jenis_data','user_id'];
}
