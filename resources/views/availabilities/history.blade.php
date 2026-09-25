@extends('layouts.tutor')

@section('title', 'Schedule History')

@section('content')

<div class="page-header">
    <h1>Schedule History</h1>
    <p class="page-description">View your saved available teaching times.</p>
</div>

<div class="schedule-header">
    <div>
        <h2 class="section-title">Available Time History</h2>
    </div>

    <div class="schedule-links">
        <a href="{{ route('availabilities.index') }}" class="back-link">Back to My Schedule</a>
    </div>
</div>

<div class="schedule-list">
    @forelse ($availabilities as $availability)
        <div class="card profile-card schedule-item">
            <div class="card-body">
                <div class="schedule-time">
                    <p><strong>Start:</strong> {{ $availability->start_datetime->format('d/m/Y H:i') }}</p>
                    <p><strong>End:</strong> {{ $availability->end_datetime->format('d/m/Y H:i') }}</p>
                </div>

                <div class="history-time">
                    <p><strong>Created:</strong> {{ $availability->created_at->format('d/m/Y H:i') }}</p>
                    <p><strong>Last Updated:</strong> {{ $availability->updated_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>
    @empty
        <div class="schedule-placeholder">
            <p>ยังไม่มีรายการในประวัติ</p>
        </div>
    @endforelse
</div>

@endsection
