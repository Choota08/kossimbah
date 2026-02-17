<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Kos;

class KosImage extends Model
{
    protected $table = 'kos_images';

    protected $fillable = [
        'kos_id',
        'file'
    ];

    public function kos()
    {
        return $this->belongsTo(Kos::class);
    }
}
