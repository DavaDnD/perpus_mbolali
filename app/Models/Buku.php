<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    protected $fillable = ['judul', 'pengarang', 'tahun_terbit','isbn', 'id_penerbit','id_kategori','id_sub_kategori'];

    public $timestamps= false;

    public function penerbit()
    {
        return $this->belongsTo(Penerbit::class, 'id_penerbit');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    public function subKategori()
    {
        return $this->belongsTo(SubKategori::class, 'id_sub_kategori');
    }

    public function items()
    {
        return $this->hasMany(BukuItem::class, 'id_buku');
    }

}
