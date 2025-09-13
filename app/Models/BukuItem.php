<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BukuItem extends Model
{
    protected $fillable = ['id_buku', 'kondisi', 'status','sumber','id_rak'];

    public $timestamps= false;

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'id_buku');
    }

    public function rak()
    {
        return $this->belongsTo(Rak::class, 'id_rak');
    }


}
