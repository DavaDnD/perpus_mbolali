<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubKategori extends Model
{
    protected $table='sub_kategoris';
    public $timestamps=false;
    protected $fillable=['sub_kategori', 'id_kategori'];

    // Relasi ke table kategoris via models Kategori
    public function kategori(){
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }
}
