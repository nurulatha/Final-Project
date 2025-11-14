<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $fillable = ['nama_kategori', 'kantin_id'];

    public function kantin()
    {
        return $this->belongsTo(Kantin::class);
    }
}
