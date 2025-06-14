<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tags extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'color', 'user_id'];

    /* Tag may belong to user or not */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
