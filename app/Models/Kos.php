<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\KosImage;
use App\Models\KosFacility;
use App\Models\Review;
use App\Models\Book;

class Kos extends Model
{
    protected $table = 'kos';

    protected $fillable = [
        'user_id',
        'name',
        'address',
        'price_per_month',
        'gender'
    ];

    protected $casts = [
        'price_per_month' => 'integer',
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
