<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserKasir extends Model
{
    use HasFactory;
    protected $table = 'users_kasir';
    protected $fillable = [
        'cabang_id',
        'username',
        'name',
        'password',
        'time_zone'
    ];

    public function cabang()
    {
        return $this->belongsTo(Cabang::class,'cabang_id','id');
    }
}
