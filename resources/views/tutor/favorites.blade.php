@extends('layouts.tutor')

@section('title', 'Favorite Tutors')

@section('content')

    <div class="favorites-header">
        <h1>Favorite Tutors</h1>
        <p>
            Tutors you have saved to your favorites.
        </p>
    </div>

    @if ($favorites->count() > 0)
        <div class="row g-4">
            @foreach ($favorites as $favorite)
                @php
                    $tutor = $favorite->favoritable;
                @endphp

                <div class="col-md-6 col-lg-4">
                    <div class="card favorite-card h-100">
                        <div class="card-body">
                            <h2 class="tutor-name">{{ $tutor->user->name ?? 'Unknown Tutor' }}</h2>

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

                            <div class="favorite-actions">
                                <a href="{{ route('tutor.show', $tutor) }}" class="btn btn-primary">View Tutor</a>

                                <form action="{{ route('tutor.favorite.destroy', $tutor) }}" method="POST">
                                    @csrf

                                    <button type="submit" class="btn btn-outline-danger">
                                        Remove Favorite
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="empty-favorites">
            <h2>No Favorite Tutors</h2>
            <p>
                ยังไม่มีติวเตอร์ที่ Favorite
            </p>

            <a href="{{ route('tutor.search') }}" class="btn btn-primary">Search Tutor</a>
        </div>
    @endif

@endsection