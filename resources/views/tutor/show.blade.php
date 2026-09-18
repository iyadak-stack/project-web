<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Tutor Profile</title>
</head>

<body>

    <x-tutor-navbar />

    <h1>Tutor Profile</h1>

    <hr>

    <h2>
        {{ $tutorProfile->user->name ?? 'Unknown Tutor' }}
    </h2>

    <p>
        Rating:
        ⭐ {{ number_format($tutorProfile->average_rating, 2) }}
    </p>

    <p>
        Experience:
        {{ $tutorProfile->experience_years }} years
    </p>

    <p>
        Teaching Mode:
        {{ $tutorProfile->teaching_mode }}
    </p>

    <h3>About Tutor</h3>

    <p>
        {{ $tutorProfile->bio ?? 'No bio available.' }}
    </p>

    <hr>

    <h3>Subjects Taught</h3>

    @if ($tutorProfile->subjects->count() > 0)

        <ul>

            @foreach ($tutorProfile->subjects as $subject)

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

    <hr>

    <h3>Favorite Tutor</h3>

    @if ($isFavorite)

        <form
            action="{{ route('tutor.favorite.destroy', $tutorProfile) }}"
            method="POST"
        >

            @csrf
            @method('DELETE')

            <button type="submit">
                ♥ Remove Favorite
            </button>

        </form>

    @else

        <form
            action="{{ route('tutor.favorite.store', $tutorProfile) }}"
            method="POST"
        >

            @csrf

            <button type="submit">
                ♥ Add Favorite
            </button>

        </form>

    @endif

    <hr>

    <h3>Available Schedule</h3>

    <p>
        Tutor's available schedule will be displayed here.
    </p>

    <p>
        This section will be connected to the team's
        Availability system later.
    </p>

    <hr>

    <h3>Booking</h3>

    <button type="button" disabled>
        Book Tutor
    </button>

    <p>
        Booking will be connected to the team's
        Appointment system later.
    </p>

    <br>

    <a href="{{ route('tutor.search') }}">
        Back to Search
    </a>

</body>

</html>