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
        'created_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function transfers()
    {
        return $this->hasMany(TaskTransfer::class);
    }
}
