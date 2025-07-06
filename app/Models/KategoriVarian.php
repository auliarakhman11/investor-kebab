<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriVarian extends Model
{
    use HasFactory;

    protected $table = 'kategori_varian';
    protected $fillable = ['kategori_varian'];

    public function getVarian()
    {
        return $this->hasMany(Varian::class,'kategori_varian_id','id');
    }
}
