<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kos extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'address',
        'price_per_month',
        'gender'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function images()
    {
        return $this->hasMany(KosImage::class);
    }

    public function facilities()
    {
        return $this->hasMany(KosFacility::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
