<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BukaToko extends Model
{
    use HasFactory;

    protected $table = 'buka_toko';
    protected $fillable = ['kode','cabang_id','tgl','nm_karyawan','buka','ket_kebutuhan','tutup'];

    public function cabang()
    {
        return $this->belongsTo(Cabang::class,'cabang_id','id','nm_karyawan');
    }
}
