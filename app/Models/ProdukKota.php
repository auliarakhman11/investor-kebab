<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukKota extends Model
{
    use HasFactory;

    protected $table = 'produk_kota';
    protected $fillable = ['produk_id','kota_id'];

}
