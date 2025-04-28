<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $guarded = [];

    public static function service_type()
    {
        return [
            1 => 'Testing',
            2 => 'Calibration',
            3 => 'Inspection',
            4 => 'Other'
        ];
    }
    public static function location()
    {
        return [
            1 => 'On-site',
            2 => 'Laboratory',
            3 => 'Remote',
            4 => 'Other'
        ];
    }
    public static function satisfaction_rating()
    {
        return [
            1 => 'Very Dissatisfied',
            2 => 'Dissatisfied',
            3 => 'Neutral',
            4 => 'Satisfied',
            5 => 'Very Satisfied'
        ];
    }
    public static function preferred_contact_method()
    {
        return [
            1 => 'Email',
            2 => 'Phone',
        ];
    }
    public static function status()
    {
        return [
            1 => 'Open',
            2 => 'Reviewed',
            3 => 'Action Taken',
            4 => 'Closed'
        ];
    }
    public static function service_status()
    {
        return [
            1 => 'Pending',
            2 => 'In Progress',
            3 => 'Completed'
        ];
    }
    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
