<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'user_id',
        'user_name',
        'date',
        'check_in',
        'location',
        'check_out',
    ];

    public function user(){

        return $this->belongsTo(User::class,'user_id', 'id');
    }
}
