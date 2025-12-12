<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KosImage extends Model
{
    protected $fillable = ['kos_id', 'file'];

    public function kos()
    {
        return $this->belongsTo(Kos::class);
    }
}
