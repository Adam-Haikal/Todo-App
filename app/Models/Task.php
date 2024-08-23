<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;

    // Change table name todos_app to task_listings
    protected $table = 'task_listings';

    protected $fillable = [
        'title',
        'description',
        'is_completed'
    ];

    // Task belong to List
    public function listTask()
    {
        return $this->belongsTo(ListTask::class);
    }
}
