<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'kos_id',
        'user_id',
        'start_date',
        'end_date',
        'status',
    ];

    /**
     * Cast tanggal ke Carbon
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
    ];

    /* ======================
       RELATIONS
       ====================== */

    public function kos()
    {
        return $this->belongsTo(Kos::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /* ======================
       STATUS HELPERS
       ====================== */

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isConfirmed(): bool
    {
        return $this->status === 'confirmed';
    }

    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    public function isCancelled(): bool
    {
        return $this->status === 'cancelled';
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }
}
