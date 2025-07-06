<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;
    protected $table = 'karyawan';
    protected $fillable = ['nama','no_tlp','alamat','tgl_masuk','kota_id','gapok','aktif'];

    public function kota()
    {
        return $this->belongsTo(Kota::class,'kota_id','id');
    }
}
