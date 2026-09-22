@extends('layouts.tutor')

@section('title', 'Favorite Tutors')

@section('content')

    <h1>Favorite Tutors</h1>

    @if ($favorites->count() > 0)

        @foreach ($favorites as $favorite)

            @php
                $tutor = $favorite->favoritable;
            @endphp

            <div>
                <h2>
                    {{ $tutor->user->name ?? 'Unknown Tutor' }}
                </h2>

                <p>
                    Bio:
                    {{ $tutor->bio ?? 'No bio available' }}
                </p>

                <p>
                    Experience:
                    {{ $tutor->experience_years }} years
                </p>

                <p>
                    Rating:
                    {{ $tutor->average_rating }}
                </p>

                <p>
                    Teaching Mode:
                    {{ $tutor->teaching_mode }}
                </p>

                <form
                    action="{{ route('tutor.favorite.destroy', $tutor) }}"
                    method="POST"
                >
                    @csrf

                    <button type="submit">
                        ♥ Remove Favorite
                    </button>
                </form>
            </div>

            <hr>

        @endforeach

    @else

        <p>
            ยังไม่มีติวเตอร์ที่ Favorite
        </p>

    @endif

<br>

@endsection