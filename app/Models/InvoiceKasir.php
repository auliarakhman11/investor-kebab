<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceKasir extends Model
{
    use HasFactory;

    protected $table = 'invoice_kasir';
    protected $fillable = ['status','void','admin','cabang_id'];

    public function getPenjualan()
    {
        return $this->hasMany(PenjualanKasir::class,'no_invoice','no_invoice');
    }

    public function getPenjualanKaryawan()
    {
        return $this->hasMany(PenjualanKaryawan::class,'no_invoice','no_invoice')->groupBy('karyawan_id');
    }

    public function cabang()
    {
        return $this->belongsTo(Cabang::class,'cabang_id','id');
    }

    public function delivery()
    {
        return $this->belongsTo(Delivery::class,'delivery_id','id');
    }

    public function pembayaran()
    {
        return $this->belongsTo(Pembayaran::class,'pembayaran_id','id');
    }
}
