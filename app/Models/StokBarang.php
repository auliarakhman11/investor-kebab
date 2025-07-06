<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokBarang extends Model
{
    use HasFactory;

    protected $table = 'gaji_karyawan';
    protected $fillable = ['kd_gabungan','karyawan_id','gapok','pendapatan','pesen1','persen2','gaji_persen','tgl1','tgl2','user_id'];
}
