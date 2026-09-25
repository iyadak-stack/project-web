<?php

namespace App\Http\Controllers;

use App\Http\Requests\Scheduling\CheckScheduleRequest;
use App\Services\Scheduling\AvailabilityService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;

class CheckScheduleController extends Controller
{
    public function index(): View
    {
        return view('check-schedule.index');
    }

    public function check(CheckScheduleRequest $request, AvailabilityService $availabilityService): View
    {
        $data = $request->validated();
        $studentId = (string) $request->user()->getAuthIdentifier();

        $times = $availabilityService->findSharedTimes(
            $studentId,
            $data['tutor_id'],
            Carbon::parse($data['start_datetime']),
            Carbon::parse($data['end_datetime']),
        );

        return view('check-schedule.index', [
            'times' => $times,
            'filters' => $data,
        ]);
    }
}
