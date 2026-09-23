@extends('layouts.tutor')

@section('title', 'Tutor Ranking')

@section('content')

    <div class="ranking-header">
        <h1>Tutor Ranking</h1>
        <p>
            จัดอันดับติวเตอร์ตามคะแนนรีวิวและประสบการณ์
        </p>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($tutors->count() > 0)
        <div class="ranking-list">
            @foreach ($tutors as $index => $tutor)
                <div class="card ranking-card">
                    <div class="card-body">
                        <div class="ranking-number">
                            #{{ $index + 1 }}
                        </div>
                        <h2 class="ranking-name">{{ $tutor->user->name ?? 'Unknown Tutor' }}</h2>

                        <div class="ranking-info">
                            <div>
                                <span>Rating</span>

                                <strong>
                                    {{ number_format($tutor->average_rating, 2) }} / 5.00
                                </strong>
                            </div>

                            <div>
                                <span>Experience</span>

                                <strong>
                                    {{ $tutor->experience_years }} years
                                </strong>
                            </div>

                            <div>
                                <span>Teaching Mode</span>

                                <strong>
                                    {{ ucfirst($tutor->teaching_mode) }}
                                </strong>
                            </div>
                        </div>

                        @php
                            $isFavorite = auth()->user()
                                ->favorites()
                                ->where('favoritable_type', \App\Models\TutorProfile::class)
                                ->where('favoritable_id', $tutor->id)
                                ->exists();
                        @endphp
                        <div class="ranking-actions">

                            <a href="{{ route('tutor.show', $tutor) }}" class="btn btn-primary">View Tutor</a>
                            @if ($isFavorite)
                                <form action="{{ route('tutor.favorite.destroy', $tutor) }}" method="POST">
                                    @csrf

                                    <button type="submit" class="btn btn-outline-danger">Unfavorite</button>
                                </form>

                            @else
                                <form action="{{ route('tutor.favorite.store', $tutor) }}" method="POST">
                                    @csrf

                                    <button type="submit" class="btn btn-outline-primary">Favorite</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    @else
        <div class="empty-ranking">
            <h2>ยังไม่มีข้อมูลติวเตอร์</h2>
            <p>
                ยังไม่มีข้อมูลสำหรับจัดอันดับติวเตอร์
            </p>

            <a href="{{ route('tutor.search') }}" class="btn btn-primary">Search Tutor</a>
        </div>
    @endif

@endsection
