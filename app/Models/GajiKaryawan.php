<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GajiKaryawan extends Model
{
    use HasFactory;

    protected $table = 'gaji_karyawan';
    protected $fillable = ['kd_gabungan','kota_id','karyawan_id','gapok','pendapatan','persen1','persen2','gaji_persen','kasbon','audit','leader','rolling','ms','tgl1','tgl2','user_id'];
}
