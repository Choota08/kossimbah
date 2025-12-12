<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['kos_id', 'user_id', 'comment'];

    public function kos()
    {
        return $this->belongsTo(Kos::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

