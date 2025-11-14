<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kantin extends Model
{
    protected $fillable = ['nama_kantin', 'lokasi', 'user_id'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
