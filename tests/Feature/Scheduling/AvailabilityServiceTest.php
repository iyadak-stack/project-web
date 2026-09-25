<?php

namespace Tests\Feature\Scheduling;

use App\Services\Scheduling\AvailabilityService;
use App\Services\Scheduling\ScheduleMatcher;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class AvailabilityServiceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Schema::create('availabilities', function (Blueprint $table): void {
            $table->char('availability_id', 10)->primary();
            $table->char('user_id', 10);
            $table->dateTime('start_datetime');
            $table->dateTime('end_datetime');
            $table->timestamps();
        });

        Schema::create('student_profiles', function (Blueprint $table): void {
            $table->id();
            $table->integer('user_id');
        });

        Schema::create('tutor_profiles', function (Blueprint $table): void {
            $table->id();
            $table->integer('user_id');
        });

        Schema::create('appointments', function (Blueprint $table): void {
            $table->string('Appointment_id', 10)->primary();
            $table->string('status', 45);
            $table->dateTime('start_datetime')->nullable();
            $table->dateTime('end_datetime')->nullable();
            $table->string('Subject_subject_id', 10);
            $table->string('Tutor_profiles_tutor_id', 10);
            $table->string('Student_profiles_student_id', 10);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    protected function tearDown(): void
    {
        Schema::dropIfExists('appointments');
        Schema::dropIfExists('tutor_profiles');
        Schema::dropIfExists('student_profiles');
        Schema::dropIfExists('availabilities');

        parent::tearDown();
    }

    public function test_it_uses_real_appointment_times_and_ignores_cancelled_appointments(): void
    {
        DB::table('student_profiles')->insert(['id' => 1, 'user_id' => 101]);
        DB::table('tutor_profiles')->insert(['id' => 2, 'user_id' => 202]);

        DB::table('availabilities')->insert([
            [
                'availability_id' => 'AVAIL00001',
                'user_id' => '101',
                'start_datetime' => '2026-09-30 15:00:00',
                'end_datetime' => '2026-09-30 17:00:00',
            ],
            [
                'availability_id' => 'AVAIL00002',
                'user_id' => '202',
                'start_datetime' => '2026-09-30 15:00:00',
                'end_datetime' => '2026-09-30 17:00:00',
            ],
        ]);

        DB::table('appointments')->insert([
            [
                'Appointment_id' => 'APP0000001',
                'status' => 'confirmed',
                'start_datetime' => '2026-09-30 15:00:00',
                'end_datetime' => '2026-09-30 16:00:00',
                'Subject_subject_id' => 'SUBJECT001',
                'Tutor_profiles_tutor_id' => '2',
                'Student_profiles_student_id' => '1',
            ],
            [
                'Appointment_id' => 'APP0000002',
                'status' => 'cancelled',
                'start_datetime' => '2026-09-30 16:00:00',
                'end_datetime' => '2026-09-30 17:00:00',
                'Subject_subject_id' => 'SUBJECT001',
                'Tutor_profiles_tutor_id' => '2',
                'Student_profiles_student_id' => '1',
            ],
        ]);

        $service = new AvailabilityService(new ScheduleMatcher);

        $times = $service->findSharedTimes(
            '101',
            '202',
            Carbon::parse('2026-09-30 15:00'),
            Carbon::parse('2026-09-30 17:00'),
        );

        $this->assertSame([
            ['start' => '2026-09-30 16:00', 'end' => '2026-09-30 17:00'],
        ], $times);
    }
}
