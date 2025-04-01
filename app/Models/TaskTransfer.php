<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskTransfer extends Model
{
    protected $table = 'task_transfers';

    protected $fillable = [
        'task_id',
        'old_user_id',
        'new_user_id',
        'transferred_by',
        'task_description',
        'task_remark',
    ];
    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id');
    }

    public function oldUser()
    {
        return $this->belongsTo(User::class, 'old_user_id');
    }

    public function newUser()
    {
        return $this->belongsTo(User::class, 'new_user_id');
    }

    public function transferredBy()
    {
        return $this->belongsTo(User::class, 'transferred_by');
    }
}
