<?php

namespace App\Services\Scheduling;

use App\Models\Appointment;
use App\Models\Availability;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;

class AvailabilityService
{
    public function __construct(private ScheduleMatcher $scheduleMatcher) {}

    public function findSharedTimes(string $studentId, string $tutorId, Carbon $rangeStart, Carbon $rangeEnd): array
    {
        $studentTimes = $this->findAvailabilities($studentId, $rangeStart, $rangeEnd);
        $tutorTimes = $this->findAvailabilities($tutorId, $rangeStart, $rangeEnd);
        $bookedTimes = $this->findAppointments($studentId, $tutorId, $rangeStart, $rangeEnd);

        return $this->scheduleMatcher->match($studentTimes, $tutorTimes, $bookedTimes, $rangeStart, $rangeEnd);
    }

    private function findAvailabilities(string $userId, Carbon $rangeStart, Carbon $rangeEnd): array
    {
        return Availability::query()
            ->where('user_id', $userId)
            ->where('start_datetime', '<', $rangeEnd)
            ->where('end_datetime', '>', $rangeStart)
            ->orderBy('start_datetime')
            ->get()
            ->all();
    }

    private function findAppointments(string $studentId, string $tutorId, Carbon $rangeStart, Carbon $rangeEnd): array
    {
        if (! Schema::hasColumn('appointments', 'student_id')
            || ! Schema::hasColumn('appointments', 'tutor_id')
            || ! Schema::hasColumn('appointments', 'appointment_datetime')) {
            return [];
        }

        $query = Appointment::query()
            ->where(function (Builder $query) use ($studentId, $tutorId): void {
                $query->where('student_id', $studentId)
                    ->orWhere('tutor_id', $tutorId);
            })
            ->where('appointment_datetime', '>=', $rangeStart->copy()->subHour())
            ->where('appointment_datetime', '<', $rangeEnd);

        if (Schema::hasColumn('appointments', 'status')) {
            $query->where('status', '!=', 'cancelled');
        }

        return $query->orderBy('appointment_datetime')->get()->all();
    }
}
