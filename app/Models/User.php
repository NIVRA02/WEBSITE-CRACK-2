<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Kolom is_admin ditambahkan agar bisa diisi (mass assignable).
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin', // <--- TAMBAHAN KRUSIAL
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    
    // Definisikan Relasi ke Komentar
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}