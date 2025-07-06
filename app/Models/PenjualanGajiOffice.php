<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenjualanGajiOffice extends Model
{
    use HasFactory;

    protected $table = 'penjualan_gaji_office';
    
    protected $fillable = ['buka_toko_id','cabang_id','kota_id','invoice_id','karyawan_id','jumlah','tgl','void','persen_gaji'];

}
