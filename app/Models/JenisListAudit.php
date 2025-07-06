<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisListAudit extends Model
{
    use HasFactory;

    protected $table = 'jenis_list_audit';
    protected $fillable = ['nm_jenis'];

    public function listAudit()
    {
        return $this->hasMany(ListAudit::class,'jenis_id','id');
    }
}
