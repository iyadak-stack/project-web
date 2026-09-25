@extends('layouts.tutor')

@section('title', 'Edit Student Profile')

@section('content')

    <h1>Edit Student Profile</h1>

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>
                        {{ $error }}
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    <form
        action="{{ route('student.profile.update') }}"
        method="POST"
    >
        @csrf

        <div>
            <label for="bio">
                Bio
            </label><br>

            <textarea
                id="bio"
                name="bio"
                rows="5"
            >{{ old('bio', $studentProfile->bio ?? '') }}</textarea>
        </div><br>

        <button type="submit">
            Save
        </button>

        <a href="{{ route('student.profile') }}">
            Cancel
        </a>
    </form>

@endsection