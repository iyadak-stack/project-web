<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Report;
use App\Models\ReportReason;
use App\Models\ReportEvidence;

class ReportController extends Controller
{
    public function create()
    {
        $reasons = ReportReason::all();

        return view('reports.create', compact('reasons'));
    }

        public function store(Request $request)
        {
            $request->validate([
                'reason_id' => 'required',
                'description' => 'required',
                'evidence' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            ]);

            $report = Report::create([
                'Report_id' => 'R' . strtoupper(Str::random(9)),
                'description' => $request->description,
                'status' => 'pending',
                'ReportReason_Reason_id' => $request->reason_id,
                'Users_user_id' => auth()->id(),
            ]);

            if ($request->hasFile('evidence')) {

                $file = $request->file('evidence');

                $path = $file->store('evidence', 'public');

                $evidence = ReportEvidence::create([
                    'FilePath' => $path,
                    'file_type' => $file->getClientMimeType(),
                    'Report_Report_id' => $report->Report_id,
                ]);
            }

            return back()->with('success', 'Report submitted');
        }
}
