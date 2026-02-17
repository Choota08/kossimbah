<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Kos;

class KosFacility extends Model
{
    protected $table = 'kos_facilities';

    protected $fillable = [
        'kos_id',
        'facility'
    ];

    public function kos()
    {
        return $this->belongsTo(Kos::class);
    }
}
