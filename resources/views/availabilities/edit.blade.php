@extends('layouts.tutor')

@section('title', 'Edit Available Time')

@section('content')

<div class="page-header">
    <h1>Edit Available Time</h1>
    <p class="page-description">Update your available teaching time.</p>
</div>

<div class="card profile-card schedule-form">
    <div class="card-body">
        <h2 class="section-title">Edit Available Time</h2>

        <form action="{{ route('availabilities.update', $availability) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="form-label">Start</label>
                <input class="form-input" type="datetime-local" name="start_datetime" value="{{ old('start_datetime', $availability->start_datetime->format('Y-m-d\TH:i')) }}" required>
                @error('start_datetime')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">End</label>
                <input class="form-input" type="datetime-local" name="end_datetime" value="{{ old('end_datetime', $availability->end_datetime->format('Y-m-d\TH:i')) }}" required>
                @error('end_datetime')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="schedule-actions">
                <button class="btn btn-primary" type="submit">Save Changes</button>
                <a href="{{ route('availabilities.index') }}" class="btn btn-outline-secondary">Back</a>
            </div>
        </form>
    </div>
</div>

@endsection