<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{

    protected $fillable = [
        'task_name',
        'user_id',
        'status',
        'dateLimit',
        'task_description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
