@extends('layouts.tutor')

@section('title', 'Tutor Details')

@section('content')

    {{-- Page Header --}}
    <div class="profile-header">
        <div>
            <h1>{{ $tutorProfile->user->name ?? 'Unknown Tutor' }}</h1>

            <p class="profile-description">
                View tutor information, subjects, availability, and booking options.
            </p>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card profile-card mb-4">
                <div class="card-body">
                    <h2 class="section-title">Tutor Information</h2>
                    <div class="profile-info-grid">
                        <div class="info-item">
                            <span class="info-label">Rating</span>

                            <strong>
                                {{ number_format($tutorProfile->average_rating, 2) }} / 5.00
                            </strong>
                        </div>

                        <div class="info-item">
                            <span class="info-label">Experience</span>

                            <strong>
                                {{ $tutorProfile->experience_years }} years
                            </strong>
                        </div>

                        <div class="info-item">
                            <span class="info-label">Teaching Mode</span>

                            <strong>
                                {{ ucfirst($tutorProfile->teaching_mode) }}
                            </strong>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card profile-card mb-4">
                <div class="card-body">
                    <h2 class="section-title">About Tutor</h2>
                    <p class="about-text">
                        {{ $tutorProfile->bio ?? 'No bio available.' }}
                    </p>
                </div>
            </div>

            <div class="card profile-card mb-4">
                <div class="card-body">
                    <h2 class="section-title">Subjects Taught</h2>
                    @if ($tutorProfile->subjects->count() > 0)
                        <div>
                            @foreach ($tutorProfile->subjects as $subject)
                                <span class="badge bg-light text-dark border subject-badge">
                                    {{ $subject->subject_name }}
                                </span>

                            @endforeach
                        </div>
                    @else

                        <p class="text-muted mb-0">
                            No subjects assigned yet.
                        </p>
                    @endif
                </div>
            </div>

            <div class="card profile-card mb-4">
                <div class="card-body">

                    <h2 class="section-title">Available Schedule</h2>
                    <div class="schedule-placeholder">
                        <p>
                            Tutor's available schedule will be displayed here.
                        </p>

                        <small>
                            This section will be connected to the team's
                            Availability system later.
                        </small>
                    </div>
                </div>
            </div>

            <div class="card profile-card">
                <div class="card-body">
                    <h2 class="section-title">Booking</h2>
                    <p class="text-muted">
                        Select an available time to book a lesson with this tutor.
                    </p>

                    <button type="button" class="btn btn-primary" disabled>
                        Book Tutor
                    </button>

                    <p class="booking-note">
                        Booking will be connected to the team's
                        Appointment system later.
                    </p>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card profile-card favorite-card">
                <div class="card-body">
                    <h2 class="section-title">Favorite Tutor</h2>
                    @if ($isFavorite)

                        <p class="favorite-status">
                            This tutor is in your favorites.
                        </p>

                        <form action="{{ route('tutor.favorite.destroy', $tutorProfile) }}" method="POST">
                            @csrf

                            <button type="submit" class="btn btn-outline-danger w-100">
                                Remove Favorite
                            </button>
                        </form>
                    @else
                        <p class="favorite-status">
                            Save this tutor to your favorites.
                        </p>

                        <form action="{{ route('tutor.favorite.store', $tutorProfile) }}" method="POST">
                            @csrf

                            <button type="submit" class="btn btn-outline-primary w-100">
                                Add Favorite
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="back-section">
        <a href="{{ route('tutor.search') }}" class="back-link">
            Back to Search
        </a>
    </div>
@endsection