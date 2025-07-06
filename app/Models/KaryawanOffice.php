<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KaryawanOffice extends Model
{
    use HasFactory;

    protected $table = 'karyawan_office';
    protected $fillable = ['nama','no_tlp','alamat','tgl_masuk','gapok','persen','aktif'];

    public function karyawanOfficeKota()
    {
        return $this->hasMany(karyawanOfficeKota::class,'karyawan_id','id');
    }
}
