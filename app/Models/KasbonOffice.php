<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KasbonOffice extends Model
{
    use HasFactory;

    protected $table = 'kasbon_office';
    protected $fillable = ['karyawan_id','jumlah','tgl','admin'];

    public function karyawanOffice()
    {
        return $this->belongsTo(KaryawanOffice::class,'karyawan_id','id');
    }

}
