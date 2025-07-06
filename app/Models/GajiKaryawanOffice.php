<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GajiKaryawanOffice extends Model
{
    use HasFactory;

    protected $table = 'gaji_karyawan_office';
    protected $fillable = ['kd_gabungan','karyawan_id','gapok','pendapatan','persen','kasbon','gaji_persen','tgl1','tgl2','user_id'];

}
