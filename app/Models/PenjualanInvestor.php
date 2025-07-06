<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenjualanInvestor extends Model
{
    use HasFactory;

    protected $table = 'penjualan_investor';
    
    protected $fillable = ['cabang_id','kota_id','investor_id','tgl','persen'];

}
