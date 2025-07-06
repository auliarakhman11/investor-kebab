<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kasbon extends Model
{
    use HasFactory;

    protected $table = 'kasbon';
    protected $fillable = ['kota_id','karyawan_id','jumlah','tgl','admin'];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class,'karyawan_id','id');
    }
    
}
