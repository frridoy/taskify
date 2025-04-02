<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $table = 'teams';
    protected $fillable = ['employee_id', 'team_name', 'is_team_leader', 'team_number'];

    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }
}
