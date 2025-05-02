<?php

namespace App\Models;

use Carbon\carbon;

use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    protected $table = 'notices';
    protected $fillable = ['title', 'description', 'notice_type', 'notice_for', 'reference_no', 'meeting_date_time', 'publish_date', 'expire_date', 'is_active', 'authorized_by'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($notice) {
            $notice->reference_no = self::generateReferenceNumber();
        });
    }

    /**
     * Generate the reference number for the notice.
     */
    private static function generateReferenceNumber()
    {
        $currentYear = Carbon::now()->format('Y');

        $lastReference = self::whereYear('created_at', $currentYear)
            ->orderBy('id', 'desc')
            ->first();

        $increment = $lastReference ? (int)substr($lastReference->reference_no, -4) + 1 : 1;

        $formattedIncrement = str_pad($increment, 4, '0', STR_PAD_LEFT);

        return "Taskify/{$currentYear}-{$formattedIncrement}";
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'authorized_by', 'id');
    }
}
