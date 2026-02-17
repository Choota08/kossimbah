<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role', // user | admin
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /* ======================
       RELATIONS
       ====================== */

    public function bookings()
    {
        return $this->hasMany(Book::class);
    }

    /* ======================
       ROLE HELPERS
       ====================== */

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isUser(): bool
    {
        return $this->role === 'user';
    }
}
