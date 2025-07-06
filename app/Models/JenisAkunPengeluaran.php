<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisAkunPengeluaran extends Model
{
    use HasFactory;

    protected $table = 'jenis_akun_pengeluaran';
    protected $fillable = ['jenis_akun'];
}
