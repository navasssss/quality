<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainingDropdown extends Model
{
   protected $fillable = ['name', 'type'];

    public static function getTypeOptions(): array
    {
        return [
            1 => 'Safety Training',
            2 => 'Management Training',
            3 => 'Technical Training',
        ];
    }

    public static function getOptions($type): array
    {
        return self::where('type', $type)
                   ->pluck('name', 'id')
                   ->toArray();
    }
    public static function getValue($id)
    {
        return self::find($id)->value('name');
    }
}
