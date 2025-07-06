<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenjualanKaryawan extends Model
{
    use HasFactory;

    protected $table = 'penjualan_karyawan';
    protected $fillable = ['void'];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class,'karyawan_id','id');
    }
}
