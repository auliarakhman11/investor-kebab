<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $table = 'invoice';
    protected $fillable = ['status','void','admin','cabang_id'];

    public function penjualan()
    {
        return $this->hasMany(Penjualan::class,'no_invoice','no_invoice');
    }

    public function costumer()
    {
        return $this->belongsTo(Costumer::class,'costumer_id','id');
    }

    public function cabang()
    {
        return $this->belongsTo(Cabang::class,'cabang_id','id');
    }
}
