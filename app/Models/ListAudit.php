<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListAudit extends Model
{
    use HasFactory;

    protected $table = 'list_audit';
    protected $fillable = ['jenis_id','nm_audit','aktif'];
}
