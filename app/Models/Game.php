<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $guarded = []; // Izinkan semua kolom diisi massal

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}