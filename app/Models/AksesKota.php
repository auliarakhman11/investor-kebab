<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AksesKota extends Model
{
    use HasFactory;
    protected $table = 'akses_kota';
    protected $fillable = ['kota_id','user_id'];

    public function kota()
    {
        return $this->belongsTo(Kota::class,'kota_id','id');
    }
    
}
