<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ReportReason;

class ReportReasonSeeder extends Seeder
{
    public function run(): void
    {
        ReportReason::create([
            'Reason_id' => 'R01',
            'reason_name' => 'Spam',
        ]);

        ReportReason::create([
            'Reason_id' => 'R02',
            'reason_name' => 'Harassment',
        ]);

        ReportReason::create([
            'Reason_id' => 'R03',
            'reason_name' => 'Inappropriate Content',
        ]);

        ReportReason::create([
            'Reason_id' => 'R04',
            'reason_name' => 'Other',
        ]);
    }
}