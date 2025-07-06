<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JagaOutlet extends Model
{
    use HasFactory;

    protected $table = 'jaga_outlet';
    protected $fillable = ['buka_toko_id','karyawan_id','role','tgl','cabang_id'];

    public function cabang()
    {
        return $this->belongsTo(Cabang::class,'cabang_id','id');
    }

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class,'karyawan_id','id');
    }

}
