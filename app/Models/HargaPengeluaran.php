<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HargaPengeluaran extends Model
{
    use HasFactory;

    protected $table = 'harga_pengeluaran';
    protected $fillable = ['akun_id','cabang_id','harga'];

    public function akun()
    {
        return $this->belongsTo(AkunPengeluaran::class,'akun_id','id');
    }

    public function cabang()
    {
        return $this->belongsTo(Cabang::class,'cabang_id','id');
    }
}
