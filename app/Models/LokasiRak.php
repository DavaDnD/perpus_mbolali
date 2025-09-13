<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LokasiRak extends Model
{
    use HasFactory;

    protected $table = 'lokasi_raks';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = ['ruang'];

    public function raks()
    {
        return $this->hasMany(Rak::class, 'id_lokasi', 'id');
    }
}
