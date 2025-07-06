<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class karyawanOfficeKota extends Model
{
    use HasFactory;

    protected $table = 'karyawan_office_kota';
    protected $fillable = ['cabang_id','karyawan_id'];

    public function cabang()
    {
        return $this->belongsTo(Cabang::class,'cabang_id','id');
    }

}
