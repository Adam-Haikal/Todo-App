<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;

    // Change table name todos_app to task_listings
    protected $table = 'task_listings';

    protected $casts = [
        'is_completed' => 'boolean',
    ];
    
    protected $fillable = [
        'list_task_id',
        'task_name',
        'description',
        'is_completed'
    ];
    // protected $guarded = [];

    // Task belong to List
    public function listTask()
    {
        return $this->belongsTo(ListTask::class);
    }

    public function tags()
    {
        // return $this->belongsToMany(Tag::class, 'task_tag', 'task_listing_id', 'tag_id');
        return $this->belongsToMany(Tag::class, foreignPivotKey: 'task_listing_id');
    }
}
