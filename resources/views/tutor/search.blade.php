@extends('layouts.tutor')

@section('title', 'Search Tutor or Subject')

@section('content')
    <h1>Search Tutor or Subject</h1>
    <p>
        Search for a tutor or subject using one search box.
    </p>

    <form action="{{ route('tutor.search') }}" method="GET">
        <input
            type="text"
            id="search"
            name="search"
            value="{{ $search }}"
            placeholder="Search tutor or subject..."
        >
        <button type="submit">
            Search
        </button>
    </form>

    @if ($search !== '')<hr>
        <h2>Search Results for "{{ $search }}"</h2>

        {{-- Tutor Results --}}

        @if ($tutors->count() > 0)
            <h3>Tutors</h3>
            @foreach ($tutors as $tutor)
                <div>
                    <h4>
                        {{ $tutor->user->name ?? 'Unknown Tutor' }}
                    </h4>

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
                        Bio:
                        {{ $tutor->bio ?? 'No bio available.' }}
                    </p>

                    <strong>
                        Subjects taught:
                    </strong>
                    @if ($tutor->subjects->count() > 0)
                        <ul>
                            @foreach ($tutor->subjects as $subject)
                                <li>
                                    {{ $subject->subject_name }}
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p>
                            No subjects assigned yet.
                        </p>
                    @endif
                    <a href="{{ route('tutor.show', $tutor) }}">
                        View Tutor
                    </a>
                </div><hr>
            @endforeach
        @endif

        {{-- Subject Results --}}
        @if ($subjects->count() > 0)
            <h3>Subjects</h3>
            @foreach ($subjects as $subject)
                <div>
                    <h4>
                        {{ $subject->subject_name }}
                    </h4>
                    <p>
                        Subject ID:
                        {{ $subject->Subjec_id }}
                    </p>
                    <strong>
                        Tutors who teach this subject:
                    </strong>
                    @if ($subject->tutors->count() > 0)
                        <ul>
                            @foreach ($subject->tutors as $tutor)
                                <li>
                                    <a href="{{ route('tutor.show', $tutor) }}">
                                        {{ $tutor->user->name ?? 'Unknown Tutor' }}
                                    </a>
                                    <br>
                                    Rating:
                                    ⭐ {{ number_format($tutor->average_rating, 2) }}
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p>
                            No tutors assigned yet.
                        </p>
                    @endif
                </div><hr>
            @endforeach
        @endif

        {{-- No Results --}}
        @if ($tutors->count() === 0 && $subjects->count() === 0)
            <p>
                No tutors or subjects found.
            </p>
        @endif
    @endif
@endsection