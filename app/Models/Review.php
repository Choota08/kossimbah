<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Kos;
use App\Models\User;

class Review extends Model
{
    protected $table = 'reviews';

    protected $fillable = [
        'kos_id',
        'user_id',
        'comment'
    ];

    public function kos()
    {
        return $this->belongsTo(Kos::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
