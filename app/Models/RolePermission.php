<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    use HasFactory;

    protected $table = 'role_permissions';
    protected $primaryKey = 'permission_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'role_id',
        'description'
    ];

    /**
     * Each permission belongs to one role.
     */
    public function roles()
    {
        return $this->belongsTo(UserRole::class, 'role_id', 'role_id');
    }
}
