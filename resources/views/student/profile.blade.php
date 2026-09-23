@extends('layouts.tutor')

@section('title', 'Student Profile')

@section('content')

    <h1>Student Profile</h1>

    @if (session('success'))
        <p>
            {{ session('success') }}
        </p>
    @endif

    <p>
        Name:
        {{ auth()->user()->name }}
    </p>

    @if ($studentProfile)
        <p>
            Bio:
            {{ $studentProfile->bio ?? 'No bio available.' }}
        </p>
    @else
        <p>
            You don't have a student profile yet.
        </p>

    @endif
    <br>
    <a href="{{ route('student.profile.edit') }}">
        <button type="button">
            Edit Profile
        </button>
    </a>

@endsection