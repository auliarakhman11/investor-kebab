<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gapok extends Model
{
    use HasFactory;

    protected $table = 'gapok';
    protected $fillable = ['karyawan_id','gapok','tgl','kota_id'];
}
