<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
  protected $table = 'equipments'; // Change 'equipments' if your table name is different
    protected $fillable = [
    'asset_number',
    'equipment_name',
    'equipment_party',
    'test_method',
    'manufacturer',
    'manufacturer_model',
    'serial_number',
    'calibration_date',
    'frequency',
    'due_date',
    'status',
    'condition',
    'repair_details',
    'certificate',
    'photographs',
];
protected $casts = [
    'calibration_date' => 'date',
    'due_date' => 'date',
    'status' => 'integer',
    'condition' => 'integer',
    'frequency' => 'integer',
    'photographs' => 'json', // Since it stores multiple files as JSON
];

const STATUS_CALIBRATED = 1;
const STATUS_CALIBRATION_DUE = 2;

public static function getStatusOptions()
{
    return [
        self::STATUS_CALIBRATED => 'Calibrated',
        self::STATUS_CALIBRATION_DUE => 'Calibration Due',
    ];
}

const CONDITION_IN_SERVICE = 1;
const CONDITION_OUT_OF_SERVICE = 2;

public static function getConditionOptions()
{
    return [
        self::CONDITION_IN_SERVICE => 'In Service',
        self::CONDITION_OUT_OF_SERVICE => 'Out of Service',
    ];
}
public function getCertificateUrlAttribute()
{
    return $this->certificate ? asset('uploads/' . $this->certificate) : null;
}
}
