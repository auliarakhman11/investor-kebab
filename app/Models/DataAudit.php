<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataAudit extends Model
{
    use HasFactory;

    protected $table = 'data_audit';
    protected $fillable = ['buka_toko_id','cabang_id','karyawan_id','list_id','tgl','user_id'];
}
