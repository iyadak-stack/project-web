@extends('layouts.tutor')

@section('title', 'Check Matching Time')

@section('content')

<div class="page-header">
    <h1>Check Matching Time</h1>
    <p class="page-description">Find available time that matches with a tutor.</p>
</div>

<div class="schedule-header">
    <div>
        <h2 class="section-title">Search Available Time</h2>
        <p class="section-description">Enter the tutor account ID and the time range you want to check.</p>
    </div>

    <div class="schedule-links">
        <a href="{{ route('availabilities.index') }}" class="back-link">Back to My Schedule</a>
    </div>
</div>

<div class="card profile-card schedule-form">
    <div class="card-body">
        <h2 class="section-title">Check Matching Time</h2>

        <form action="{{ route('schedule.check.results') }}" method="POST">
            @csrf

            <div class="form-group">
                <label class="form-label">Tutor Account ID</label>
                <input class="form-input" type="text" name="tutor_id" maxlength="10" value="{{ old('tutor_id', ($filters ?? [])['tutor_id'] ?? '') }}" required>
                @error('tutor_id')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Start</label>
                    <input class="form-input" type="datetime-local" name="start_datetime" value="{{ old('start_datetime', ($filters ?? [])['start_datetime'] ?? '') }}" required>
                    @error('start_datetime')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">End</label>
                    <input class="form-input" type="datetime-local" name="end_datetime" value="{{ old('end_datetime', ($filters ?? [])['end_datetime'] ?? '') }}" required>
                    @error('end_datetime')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <button class="btn btn-primary" type="submit">Check Matching Time</button>
        </form>
    </div>
</div>

@if (isset($times))
    <div class="schedule-section">
        <h2 class="section-title">Matching Available Time</h2>

        <div class="schedule-list">
            @forelse ($times as $time)
                <div class="card profile-card schedule-item">
                    <div class="card-body">
                        <div class="schedule-time">
                            <p><strong>Start:</strong> {{ \Illuminate\Support\Carbon::parse($time['start'])->format('d/m/Y H:i') }}</p>
                            <p><strong>End:</strong> {{ \Illuminate\Support\Carbon::parse($time['end'])->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="schedule-placeholder">
                    <p>ไม่พบช่วงเวลาว่างตรงกันในช่วงที่เลือก</p>
                </div>
            @endforelse
        </div>
    </div>
@endif

@endsection