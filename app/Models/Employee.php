<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    const ROLE_OWNER = 1;
    const ROLE_MANAGER = 2;
    const ROLE_EMPLOYEE = 3;

    protected $fillable = [
        'name', 'title', 'email', 'department_id', 'role', 'manager_id', 'profile_pic', 'responsibility'
    ];

    public function getRoleNameAttribute()
    {
        return match ($this->role) {
            self::ROLE_OWNER => 'CEO / President / Vice President',
            self::ROLE_MANAGER => 'Manager',
            default => 'Employee',
        };
    }
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function manager(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'manager_id');
    }

    public function subordinates(): HasMany
    {
        return $this->hasMany(Employee::class, 'manager_id');
    }

    public function scopeManagers($query)
    {
        return $query->where('role', 'manager');
    }

    public function scopeEmployees($query)
    {
        return $query->where('role', 'employee');
    }
}
