<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
    protected $table = 'leave_requests';

    public function user(){

        return $this->belongsTo(User::class, 'user_id', 'id');
    }

     public function reviewedBy(){

        return $this->belongsTo(User::class, 'reviewed_by', 'id');
    }
}
