<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurnal extends Model
{
    use HasFactory;

    protected $table = 'jurnal';
    protected $fillable = ['kd_gabungan','buka_toko_id','transaksi_id','kota_id','cabang_id','buku_id','akun_id','bahan_id','barang_id','varian_id','debit','kredit','qty_debit','qty_kredit','user_id','tgl','ket','void'];

    public function akun()
    {
        return $this->belongsTo(AkunPengeluaran::class,'akun_id','id');
    }

    public function cabang()
    {
        return $this->belongsTo(Cabang::class,'cabang_id','id');
    }
}
