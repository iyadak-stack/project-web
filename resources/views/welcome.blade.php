@extends('layouts.tutor')

@section('title', 'Home')

@section('content')

    <div class="home-hero">
        <div>
            <h1>Welcome to PeerTutor</h1>
            <p>
                Find tutors, explore subjects, and manage your lessons.
            </p>

            <a href="{{ route('tutor.search') }}" class="btn btn-primary">
                Search Tutor / Subject
            </a>
        </div>
    </div>

    <section class="home-section">
        <div class="section-header">
            <div>
                <h2>Top Rated Tutors</h2>
                <p>
                    Explore our highest-rated tutors.
                </p>
            </div>

            <a href="{{ route('tutor.ranking') }}" class="btn btn-outline-primary">
                View Ranking
            </a>
        </div>

        @if ($topTutors->count() > 0)
            <div class="row g-4">
                @foreach ($topTutors as $tutor)
                    <div class="col-md-6 col-lg-4">

                        <div class="card tutor-card h-100">
                            <div class="card-body">
                                <div class="tutor-rank">
                                    #{{ $loop->iteration }}
                                </div>

                                <h3 class="tutor-name">
                                    {{ $tutor->user->name ?? 'Unknown Tutor' }}
                                </h3>

                                <div class="tutor-info">
                                    <strong>Rating</strong>
                                    <span>
                                        {{ number_format($tutor->average_rating, 2) }} / 5.00
                                    </span>
                                </div>

                                <div class="tutor-info">
                                    <strong>Experience</strong>
                                    <span>
                                        {{ $tutor->experience_years }} years
                                    </span>
                                </div>

                                <div class="tutor-info">
                                    <strong>Teaching Mode</strong>
                                    <span>
                                        {{ ucfirst($tutor->teaching_mode) }}
                                    </span>
                                </div>

                                <div class="tutor-subjects">
                                    <strong>Subjects</strong>

                                    <div class="mt-2">
                                        @if ($tutor->subjects->count() > 0)
                                            @foreach ($tutor->subjects as $subject)
                                                <span class="badge bg-light text-dark border me-1 mb-1">
                                                    {{ $subject->subject_name }}
                                                </span>
                                            @endforeach

                                        @else
                                            <span class="text-muted">
                                                No subjects assigned yet.
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <a href="{{ route('tutor.show', $tutor) }}" class="btn btn-primary w-100">
                                        View Tutor
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="alert alert-secondary">
                No tutors available yet.
            </div>
        @endif
    </section>

    <section class="home-section">
        <div class="section-header">
            <div>
                <h2>Top Subjects</h2>
                <p>
                    Explore subjects currently taught by our tutors.
                </p>
            </div>

            <a href="{{ route('tutor.search') }}" class="btn btn-outline-primary">
                Search Subjects
            </a>
        </div>

        @if ($topSubjects->count() > 0)
            <div class="row g-4">
                @foreach ($topSubjects as $subject)
                    <div class="col-md-6 col-lg-4">
                        <div class="card subject-card h-100">
                            <div class="card-body">
                                <div class="subject-rank">
                                    #{{ $loop->iteration }}
                                </div>

                                <h3 class="subject-name">{{ $subject->subject_name }}</h3>

                                <p class="text-muted mb-0">
                                    Tutors teaching this subject:

                                    <strong>
                                        {{ $subject->tutors->count() }}
                                    </strong>
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="alert alert-secondary">
                No subjects available yet.
            </div>
        @endif
    </section>

    <section class="home-section">
        <div class="section-header">
            <div>
                <h2>Upcoming Lessons</h2>
                <p>
                    Your upcoming lessons will appear here.
                </p>
            </div>
        </div>

        <div class="card upcoming-card">
            <div class="card-body">
                <p class="mb-0 text-muted">
                    This section will be connected to the team's
                    Appointment and Schedule system later.
                </p>
            </div>
        </div>
    </section>

@endsection