<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GapokOffice extends Model
{
    use HasFactory;

    protected $table = 'gapok_office';
    protected $fillable = ['karyawan_id','gapok','tgl','cabang_id'];
}
