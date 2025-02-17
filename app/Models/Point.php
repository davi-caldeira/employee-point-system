<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Point extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'registered_at',
    ];

    // Relationship: The user who registered the point
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
