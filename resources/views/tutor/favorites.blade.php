@extends('layouts.tutor')

@section('title', 'Favorites')

@section('content')

<div class="favorites-header">
    <h1>My Favorites</h1>
    <p>ติวเตอร์และวิชาที่คุณบันทึกไว้</p>
</div>

@if (session('success'))
    <p class="success-message">
        {{ session('success') }}
    </p>
@endif


{{-- Favorite Tutors --}}
<section class="favorite-section">

    <h2>Favorite Tutors</h2>

    @if ($tutorFavorites->count() > 0)
        <div class="row g-4">
            @foreach ($tutorFavorites as $favorite)
                @php
                    $tutor = $favorite->favoritable;
                @endphp

                <div class="col-md-6 col-lg-4">
                    <div class="card favorite-card h-100">
                        <div class="card-body">
                            <h3 class="tutor-name">
                                {{ $tutor->user->name }}
                            </h3>

                            <p>
                                Rating:
                                {{ number_format($tutor->average_rating, 2) }}
                            </p>

                            <p>
                                Experience:
                                {{ $tutor->experience_years }} years
                            </p>

                            <a
                                href="{{ route('tutor.show', $tutor) }}"
                                class="btn btn-primary"
                            >
                                View Tutor
                            </a>
                            <form
                                action="{{ route('tutor.favorite.destroy', $tutor) }}"
                                method="POST"
                                class="mt-2"
                            >
                                @csrf
                                <button
                                    type="submit"
                                    class="btn btn-outline-danger"
                                >
                                    Remove Favorite
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p>ยังไม่มีติวเตอร์ในรายการโปรด</p>
    @endif
</section>


{{-- Favorite Subjects --}}
<section class="favorite-section">

    <h2>Favorite Subjects</h2>
    @if ($subjectFavorites->count() > 0)
        <div class="row g-4">
            @foreach ($subjectFavorites as $favorite)
                @php
                    $subject = $favorite->favoritable;
                @endphp

                <div class="col-md-6 col-lg-4">
                    <div class="card favorite-card h-100">
                        <div class="card-body">
                            <h3 class="subject-name">{{ $subject->subject_name }}</h3>
                            <p>
                                Tutors:
                                {{ $subject->tutors->count() }}
                            </p>

                            <a
                                href="{{ route('tutor.search', ['search' => $subject->subject_name]) }}"
                                class="btn btn-primary"
                            >
                                Find Tutors
                            </a>

                            <form
                                action="{{ route('subject.favorite.destroy', $subject) }}"
                                method="POST"
                                class="mt-2"
                            >
                                @csrf

                                <button
                                    type="submit"
                                    class="btn btn-outline-danger"
                                >
                                    Remove Favorite
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p>ยังไม่มีวิชาในรายการโปรด</p>
    @endif

</section>

@endsection