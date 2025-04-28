<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EquipmentMaintenance extends Model
{
  protected $fillable = [
        'equipment_id', 'maintenance_date', 'service_status', 'details'
    ];

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }
    const STATUS_IN_SERVICE = 1;
    const STATUS_OUT_OF_SERVICE = 2;
    const STATUS_REPAIRED = 3;
    const STATUS_GENERAL_SERVICE = 4;

    public static function getStatusOptions()
    {
        return [
            self::STATUS_IN_SERVICE => 'In Service',
            self::STATUS_OUT_OF_SERVICE => 'Out of Service',
            self::STATUS_REPAIRED => 'Repaired',
            self::STATUS_GENERAL_SERVICE => 'General Service',
        ];
    }
}
