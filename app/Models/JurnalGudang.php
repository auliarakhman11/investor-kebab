<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JurnalGudang extends Model
{
    use HasFactory;

    protected $table = 'jurnal_gudang';
    protected $fillable = ['kode_inv','mitra','kd_gabungan','kota_id','buku_id','akun_id','bahan_id','barang_id','varian_id','debit','kredit','qty_debit','qty_kredit','user_id','tgl','ket','void'];

    public function akun()
    {
        return $this->belongsTo(AkunPengeluaran::class,'akun_id','id');
    }

    public function kota()
    {
        return $this->belongsTo(Kota::class,'kota_id','id');
    }

    public function mitra()
    {
        return $this->belongsTo(Mitra::class,'mitra_id','id');
    }

    public function bahan()
    {
        return $this->belongsTo(Bahan::class,'bahan_id','id');
    }

    public function varian()
    {
        return $this->belongsTo(Varian::class,'varian_id','id');
    }

    public function kebutuhan()
    {
        return $this->belongsTo(BarangKebutuhan::class,'barang_id','id');
    }

}
