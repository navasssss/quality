<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class TrainingProgram extends Model
{
    protected $fillable = [
        'user_id',
        'training',
        'designation',
        'department',
        'module',
        'training_date',
        'trainer_name',
        'mode',
        'training_type',
        'validity',
        'refresher_due',
        'status',
        'attachments',
    ];

    protected $casts = [
        'attachments' => 'array',
    ];
    public function module(): BelongsTo
    {
        return $this->belongsTo(TrainingDropdown::class, 'module');
    }

public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public static function getDesignationOptions($type)
    {
        $options = [
            1 => [
                1 => 'Technician',
                2 => 'Supervisor',
                3 => 'Manager',
                4 => 'Office Staff',
            ],
            2 => [
                1 => 'Supervisor',
                2 => 'Manager',
                3 => 'Lead Inspector',
                4 => 'Coordinator',
            ],
            3 => [
                1 => 'Technician',
                2 => 'Supervisor',
                3 => 'Inspector',
                4 => 'Manager',
                5 => 'Office Staff',
            ],
        ];

        return $options[$type] ?? [];
    }
    public static function getDepartmentOptions($type)
    {
        $options = [
            1 => [
                1 => 'Operations',
                2 => 'NDT',
                3 => 'Maintenance',
                4 => 'Safety',
                5 => 'Admin',
            ],
            2 => [
                1 => 'Supervisor',
                2 => 'Manager',
                3 => 'Lead Inspector',
                4 => 'Coordinator',
            ],
            3 => [
                1 => 'Technician',
                2 => 'Supervisor',
                3 => 'Inspector',
                4 => 'Manager',
                5 => 'Office Staff',
            ],
        ];

        return $options[$type] ?? [];
    }
    
    public static function getModeOptions($type)
    {
        return [
            1 => [1=>'Classroom', 2=>'Online',3=> 'Practical'],
            2 => [1=>'Classroom', 2=>'Online', 3=>'Practical', 4=>'External'],
            3 => [1=>'Classroom', 2=>'Online',3=> 'Practical'],
        ][$type] ?? [];
    }

    public static function getTrainingTypeOptions()
    {
        return [
           1=> 'Initial Certification',
         2=>   'Refresher Training',
         3=>   'Recertification',
         4=>   'VOC',
        ];
    }

    public static function getStatusOptions()
    {
        return [
          1=>  'Completed',
           2=> 'Pending',
         3=>   'Rescheduled',
         4=>   'Cancelled',
          5=>  'Failed',
          6=>  'Expired',
        ];
    }
}
