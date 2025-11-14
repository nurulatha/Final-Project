<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = ['nama_menu', 'harga', 'kategori_id', 'kantin_id', 'deskripsi', 'gambar'];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
    public function kantin()
    {
        return $this->belongsTo(Kantin::class);
    }
}
