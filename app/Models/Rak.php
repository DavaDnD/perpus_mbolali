<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rak extends Model
{
    use HasFactory;

    protected $table = 'raks';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = ['barcode','nama','kolom','baris','kapasitas', 'id_lokasi', 'id_kategori'];

    public function lokasi()
    {
        return $this->belongsTo(LokasiRak::class, 'id_lokasi');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

}
