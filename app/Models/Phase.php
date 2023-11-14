<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phase extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'is_completion',
        'order_number',
    ];

    function tasks()
    {
        return $this->hasMany(Task::class)
            ->select('tasks.*')
            ->join('users', 'tasks.user_id', 'users.id')
            ->orderBy('tasks.order_number', 'asc')
        ;
    }
}
