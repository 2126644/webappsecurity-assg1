<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\UserRole;
use App\Models\Todo;  

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password',
        'salt', 'nickname', 'avatar',
        'phone_no', 'city', 'role_id',
    ];

    /**
     * Default attribute values
     */
    protected $attributes = [
        'role_id' => 2, // Student
    ];

    protected $hidden = ['password','remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**  
     * Single role record for this user.  
     */
    public function userRole()
    {
        return $this->belongsTo(UserRole::class, 'role_id', 'role_id');
    }

    /**
     * All todos belonging to this user.
     */
    public function todos()
    {
        return $this->hasMany(Todo::class, 'user_id', 'id');
    }
}

