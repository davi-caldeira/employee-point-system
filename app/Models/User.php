<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'cpf',
        'role',         // 'employee' or 'admin'
        'position',     // job position
        'birth_date',
        'zip_code',
        'address',
        'created_by',   // ID of the administrator who registered the user
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'birth_date' => 'date',
        'password' => 'hashed',
    ];

    /**
     * Get the point records for the user.
     */
    public function points()
    {
        return $this->hasMany(Point::class);
    }

    /**
     * Get the administrator who created this user (if applicable).
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
