@extends('layouts.tutor')

@section('title', 'Tutor Details')

@section('content')

{{-- Page Header --}}

<div class="page-header">
    <h1>{{ $tutorProfile->user->name ?? 'Unknown Tutor' }}</h1>
    <p class="page-description">View tutor information, subjects, available schedule, and booking options.</p>
</div>

<div class="row g-4">

{{-- Tutor Information --}}
<div class="col-lg-8">

    <div class="card profile-card mb-4">
        <div class="card-body">
            <h2 class="section-title">Tutor Information</h2>

            <div class="info-grid">
                <div class="info-box">
                    <span class="info-label">Rating</span>
                    <strong>{{ number_format($tutorProfile->average_rating, 2) }} / 5.00</strong>
                </div>

                <div class="info-box">
                    <span class="info-label">Experience</span>
                    <strong>{{ $tutorProfile->experience_years }} years</strong>
                </div>

                <div class="info-box">
                    <span class="info-label">Teaching Mode</span>
                    <strong>{{ ucfirst($tutorProfile->teaching_mode) }}</strong>
                </div>
            </div>
        </div>
    </div>

    {{-- About Tutor --}}
    <div class="card profile-card mb-4">
        <div class="card-body">
            <h2 class="section-title">About Tutor</h2>
            <p class="about-description">{{ $tutorProfile->bio ?? 'No bio available.' }}</p>
        </div>
    </div>

    {{-- Subjects Taught --}}
    <div class="card profile-card mb-4">
        <div class="card-body">
            <h2 class="section-title">Subjects Taught</h2>

            @if ($tutorProfile->subjects->count() > 0)
                <div class="subject-list">
                    @foreach ($tutorProfile->subjects as $subject)
                        <span class="subject-tag">{{ $subject->subject_name }}</span>
                    @endforeach
                </div>
            @else
                <p class="empty-text">No subjects assigned yet.</p>
            @endif
        </div>
    </div>

    {{-- Available Schedule --}}
    <div class="card profile-card mb-4">
        <div class="card-body">
            <h2 class="section-title">Available Schedule</h2>

            @if ($availabilities->count() > 0)
                @foreach ($availabilities as $availability)
                    <div class="available-time">
                        <p><strong>Date:</strong> {{ $availability->start_datetime->format('d/m/Y') }}</p>
                        <p><strong>Time:</strong> {{ $availability->start_datetime->format('H:i') }} - {{ $availability->end_datetime->format('H:i') }}</p>
                    </div>
                @endforeach
            @else
                <div class="available-time">
                    <p>No available schedule at the moment.</p>
                </div>
            @endif
        </div>
    </div>

    {{-- Booking --}}
    <div class="card profile-card">
        <div class="card-body">
            <h2 class="section-title">Booking</h2>
            <p class="booking-description">Select an available time to book a lesson with this tutor.</p>
            <button type="button" class="btn btn-primary" disabled>Book Tutor</button>
            <p class="booking-note">The booking function will be connected to the Appointment system.</p>
        </div>
    </div>

</div>

{{-- Favorite Tutor --}}
<div class="col-lg-4">
    <div class="card profile-card favorite-box">
        <div class="card-body">
            <h2 class="section-title">Favorite Tutor</h2>

            @if ($isFavorite)
                <p class="favorite-text">This tutor is in your favorites.</p>

                <form action="{{ route('tutor.favorite.destroy', $tutorProfile) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger w-100">Remove Favorite</button>
                </form>
            @else
                <p class="favorite-text">Save this tutor to your favorites.</p>

                <form action="{{ route('tutor.favorite.store', $tutorProfile) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-primary w-100">Add Favorite</button>
                </form>
            @endif
        </div>
    </div>
</div>

</div>

{{-- Back to Search --}}

<div class="back-section">
    <a href="{{ route('tutor.search') }}" class="back-link">Back to Search</a>
</div>

@endsection
