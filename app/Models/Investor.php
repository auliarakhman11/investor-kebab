<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Investor extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $table = 'investor';
    protected $fillable = ['username','password','nm_investor'];


    public function persenInvestor()
    {
        return $this->hasMany(PersenInvestor::class,'investor_id','id');
    }

}
