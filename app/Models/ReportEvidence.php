<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportEvidence extends Model
{
    protected $table = 'report_evidences';

    public $timestamps = false;

    protected $fillable = [
        'FilePath',
        'file_type',
        'Report_Report_id',
    ];

    public function report()
    {
        return $this->belongsTo(
            Report::class,
            'Report_Report_id',
            'Report_id'
        );
    }
}