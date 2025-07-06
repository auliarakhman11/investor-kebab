<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cabang extends Model
{
    use HasFactory;
    protected $table = 'cabang';
    protected $fillable = ['nama','alamat','foto','map','kota_id','event','possition','no_tlpn','email_shopee','email_grab','email_gojek','time_zone','off'];

    public function hargaPengeluaran()
    {
        return $this->hasMany(HargaPengeluaran::class,'cabang_id','id');
    }
}
