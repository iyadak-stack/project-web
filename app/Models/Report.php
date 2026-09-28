<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $primaryKey = 'Report_id';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'Report_id',
        'description',
        'status',
        'ReportReason_Reason_id',
        'Users_user_id',
    ];

    public function reason()
    {
        return $this->belongsTo(
            ReportReason::class,
            'ReportReason_Reason_id',
            'Reason_id'
        );
    }

    public function user()
    {
        return $this->belongsTo(
            User::class,
            'Users_user_id',
            'user_id'
        );
    }

    public function evidences()
    {
        return $this->hasMany(
            ReportEvidence::class,
            'Report_Report_id',
            'Report_id'
        );
    }
}
