<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subtask extends Model
{
    protected $casts = [
        'completed' => 'boolean',
    ];

    protected $fillable = ['name', 'task_id', 'completed', 'completed_at'];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
