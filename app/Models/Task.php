<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'title', 'description', 'due_date', 'status', 'priority',
    ];

    // Creator of the task
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Assigned users (for later many-to-many setup)
    public function assignees()
    {
        return $this->belongsToMany(User::class, 'task_user', 'task_id', 'user_id');
    }
}
