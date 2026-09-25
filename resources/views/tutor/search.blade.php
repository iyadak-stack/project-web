@extends('layouts.tutor')

@section('title', 'Search Tutor or Subject')

@section('content')

    <div class="search-header">
        <h1>Search Tutor or Subject</h1>
        <p>
            Search for a tutor or subject using one search box.
        </p>
    </div>

    <div class="search-box">
        <form action="{{ route('tutor.search') }}" method="GET">
            <div class="row g-2">

                <div class="col-md-10">
                    <input
                        type="text"
                        id="search"
                        name="search"
                        value="{{ $search }}"
                        class="form-control"
                        placeholder="Search tutor or subject..."
                    >
                </div>

                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        Search
                    </button>
                </div>

            </div>
        </form>
    </div>

    @if ($search !== '')
        <div class="results-header">
            <h2>Search Results</h2>

            <p>
                Results for:
                <strong>"{{ $search }}"</strong>
            </p>
        </div>

        @if ($tutors->count() > 0)
            <section class="result-section">
                <div class="section-section-title">
                    <h3>Tutors</h3>

                    <span class="result-count">
                        {{ $tutors->count() }} tutor(s)
                    </span>
                </div>

                <div class="row g-4">
                    @foreach ($tutors as $tutor)
                        <div class="col-md-6 col-lg-4">
                            <div class="card tutor-card h-100">
                                <div class="card-body">
                                    <h4 class="tutor-name">
                                        {{ $tutor->user->name ?? 'Unknown Tutor' }}
                                    </h4>

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

                                    <div class="tutor-bio">
                                        <strong>Bio</strong>

                                        <p>
                                            {{ $tutor->bio ?? 'No bio available.' }}
                                        </p>
                                    </div>

                                    <div class="tutor-subjects">
                                        <strong>Subjects taught</strong>

                                        <div class="mt-2">
                                            @if ($tutor->subjects->count() > 0)
                                                @foreach ($tutor->subjects as $subject)
                                                    <span class="badge bg-light text-dark border me-1 mb-1">
                                                        {{ $subject->subject_name }}
                                                    </span>

                                                @endforeach
                                            @else
                                                <p class="text-muted mb-0">
                                                    No subjects assigned yet.
                                                </p>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- View Tutor --}}
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
            </section>

        @endif

        @if ($subjects->count() > 0)
            <section class="result-section">
                <div class="section-title">
                    <h3>Subjects</h3>

                    <span class="result-count">
                        {{ $subjects->count() }} subject(s)
                    </span>
                </div>

                <div class="row g-4">

                    @foreach ($subjects as $subject)
                        <div class="col-md-6 col-lg-4">
                            <div class="card subject-card h-100">
                                <div class="card-body">
                                    <h4 class="subject-name">
                                        {{ $subject->subject_name }}
                                    </h4>

                                    <p class="text-muted">
                                        Tutors who teach this subject:
                                        <strong>
                                            {{ $subject->tutors->count() }}
                                        </strong>
                                    </p>

                                    @if ($subject->tutors->count() > 0)
                                        <div class="subject-tutors">
                                            <strong>Tutors</strong>

                                            <div class="mt-2">
                                                @foreach ($subject->tutors as $tutor)
                                                    <div class="tutor-result">
                                                        <a href="{{ route('tutor.show', $tutor) }}" class="tutor-link">
                                                            {{ $tutor->user->name ?? 'Unknown Tutor' }}
                                                        </a>

                                                        <span class="text-muted">
                                                            Rating:
                                                            {{ number_format($tutor->average_rating, 2) }}
                                                        </span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @else
                                        <p class="text-muted">
                                            No tutors assigned yet.
                                        </p>

                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        @if ($tutors->count() === 0 && $subjects->count() === 0)
            <div class="alert alert-secondary no-results">
                No tutors or subjects found.
            </div>

        @endif
    @endif
@endsection