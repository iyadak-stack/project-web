@extends('layouts.tutor')

@section('title', 'Home')

@section('content')

    <h1>PeerTutor</h1>
    <p>
        Find tutors, explore subjects, and manage your lessons.
    </p><hr>
    <h2>⭐ Top Rated Tutors</h2>

    @if ($topTutors->count() > 0)
        @foreach ($topTutors as $tutor)
            <div>
                <h3>
                    {{ $tutor->user->name ?? 'Unknown Tutor' }}
                </h3>

                <p>
                    Rating:
                    ⭐ {{ number_format($tutor->average_rating, 2) }}
                </p>

                <p>
                    Experience:
                    {{ $tutor->experience_years }} years
                </p>

                <p>
                    Teaching Mode:
                    {{ $tutor->teaching_mode }}
                </p>
                <p>
                    Subjects:
                    @if ($tutor->subjects->count() > 0)
                        @foreach ($tutor->subjects as $subject)
                            {{ $subject->subject_name }}@if (!$loop->last), @endif
                        @endforeach
                    @else
                        No subjects assigned yet.
                    @endif
                </p>

                <a href="{{ route('tutor.show', $tutor) }}">
                    View Tutor
                </a>
            </div><hr>
        @endforeach
    @else
        <p>No tutors available yet.</p>
    @endif

    <h2>📚 Top Rated Subjects</h2>
    <p>
        Subject ratings will be connected to the Review system later.
    </p>

    @if ($topSubjects->count() > 0)
        @foreach ($topSubjects as $subject)
            <div>
                <h3>
                    {{ $subject->subject_name }}
                </h3>
                <p>
                    Tutors teaching this subject:
                    {{ $subject->tutors->count() }}
                </p>
            </div><hr>
        @endforeach

    @else
        <p>No subjects available yet.</p>

    @endif
    <h2>📅 Upcoming Lessons</h2>

    <p>
        Your upcoming lessons will appear here.
    </p>

    <p>
        This section will be connected to the team's Appointment
        and Schedule system later.
    </p>

@endsection