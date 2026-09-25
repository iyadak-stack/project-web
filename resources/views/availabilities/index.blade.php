@extends('layouts.tutor')

@section('title', 'My Schedule')

@section('content')

<div class="page-header">
    <h1>My Schedule</h1>
    <p class="page-description">Manage your available teaching time.</p>
</div>

<div class="schedule-header">
    <div>
        <h2 class="section-title">Available Time</h2>
        <p class="section-description">Add the date and time when you are available to teach.</p>
    </div>

    <div class="schedule-links">
        <a href="{{ route('availabilities.history') }}" class="back-link">View History</a>
        <a href="{{ route('schedule.check') }}" class="back-link">Check Matching Time</a>
    </div>
</div>

@if (session('success'))
    <p class="success-message">{{ session('success') }}</p>
@endif

<div class="card profile-card schedule-form">
    <div class="card-body">
        <h2 class="section-title">Add Available Time</h2>

        <form action="{{ route('availabilities.store') }}" method="POST">
            @csrf

            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Start</label>
                    <input class="form-input" type="datetime-local" name="start_datetime" value="{{ old('start_datetime') }}" required>
                    @error('start_datetime')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">End</label>
                    <input class="form-input" type="datetime-local" name="end_datetime" value="{{ old('end_datetime') }}" required>
                    @error('end_datetime')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <button class="btn btn-primary" type="submit">Add Available Time</button>
        </form>
    </div>
</div>

<div class="schedule-section">
    <h2 class="section-title">Saved Available Time</h2>

    <div class="schedule-list">
        @forelse ($availabilities as $availability)
            <div class="card profile-card schedule-item">
                <div class="card-body">
                    <div class="schedule-time">
                        <p><strong>Start:</strong> {{ $availability->start_datetime->format('d/m/Y H:i') }}</p>
                        <p><strong>End:</strong> {{ $availability->end_datetime->format('d/m/Y H:i') }}</p>
                    </div>

                    <div class="schedule-actions">
                        <a href="{{ route('availabilities.edit', $availability) }}" class="btn btn-outline-primary">Edit</a>

                        <form action="{{ route('availabilities.destroy', $availability) }}" method="POST" onsubmit="return confirm('ลบเวลาว่างรายการนี้ไหม?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-outline-danger" type="submit">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="schedule-placeholder">
                <p>ยังไม่มีเวลาว่างที่บันทึกไว้</p>
            </div>
        @endforelse
    </div>
</div>

@endsection