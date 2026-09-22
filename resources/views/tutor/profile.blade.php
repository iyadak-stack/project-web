@extends('layouts.tutor')

@section('title', 'Tutor Profile')

@section('content')

    <h1>Tutor Profile</h1>

    @if ($tutorProfile)
        <p>
            Bio:
            {{ $tutorProfile->bio }}
        </p>

        <p>
            Experience:
            {{ $tutorProfile->experience_years }} years
        </p>

        <p>
            Rating:
            {{ $tutorProfile->average_rating }}
        </p>
        <p>
            Teaching Mode:
            {{ $tutorProfile->teaching_mode }}
        </p><br>

        <a href="{{ route('tutor.profile.edit') }}">
            <button type="button">
                Edit Profile
            </button>
        </a>
    @else
        <p>
            You don't have a tutor profile yet.
        </p>
    @endif
@endsection