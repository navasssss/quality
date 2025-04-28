<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QualityPolicy extends Model
{
    
    protected $fillable = [
        'policy_number',
        'policy_title',
        'policy_file',
        'revision',
        'create_date',
        'approved_date',
        'prepared_by',
        'reviewed_by',
        'approved_by',
        'audited_by',
        'comments',
        'auditable',
        'status'
    ];
    
    public function preparedBy()
    {
        return $this->belongsTo(User::class, 'prepared_by');
    }

    public function reviewedBy()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
    public function auditedBy(){
      return $this->belongsTo(User::class,'audited_by');
    }
     public static function generateNextPolicyNumber()
{
    $lastDocument = QualityPolicy::latest('id')->first();

    if (!$lastDocument) {
        return 'POL-001'; // First document number
    }

    // Extract numeric part and increment
    preg_match('/\d+$/', $lastDocument->policy_number, $matches);
    $nextNumber = isset($matches[0]) ? str_pad($matches[0] + 1, 3, '0', STR_PAD_LEFT) : '001';

    return "POL-$nextNumber";
}
public function getDocumentFileUrlAttribute()
    {
        return asset('uploads/' . $this->document_file);
    }
    
    const STATUS_PENDING_REVIEW = 1;
    const STATUS_PENDING_APPROVAL = 2;
    const STATUS_APPROVED = 3;
    const STATUS_WITHDRAWN = 4;

    public static function getStatusOptions()
    {
        return [
            self::STATUS_PENDING_REVIEW => 'Pending Review',
            self::STATUS_PENDING_APPROVAL => 'Pending Approval',
            self::STATUS_APPROVED => 'Approved',
            self::STATUS_WITHDRAWN => 'Withdrawn',
        ];
    }

    public function getStatusLabelAttribute()
    {
        return self::getStatusOptions()[$this->status] ?? 'Unknown';
    }
}
