<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = ['name','color'];

    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class);
    }

    public function managers(): HasMany
    {
        return $this->hasMany(Employee::class)->where('role', 2);
    }
    public function employeesOnly(): HasMany
    {
        return $this->hasMany(Employee::class)->where('role', 3);
    }
}
