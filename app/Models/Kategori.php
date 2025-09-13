<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table='kategoris';
    protected $primaryKey='id';
    public $timestamps=false;
    protected $fillable = ['nama'];

    // Relasi: ke table sub_kategoris di models SubKategori
    public function subkategori()
    {
        return $this->hasMany(SubKategori::class, 'id_kategori', 'id');
    }

}
