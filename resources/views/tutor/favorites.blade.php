@extends('layouts.tutor')
@section('title', 'รายการโปรด')
@section('content')
<div class="favorites-header">
    <h1>รายการโปรด</h1>
    <p>ติวเตอร์และวิชาที่คุณบันทึกไว้</p>
</div>

@if (session('success'))
    <p class="success-message">{{ session('success') }}</p>
@endif

<section class="favorite-section">
    <h2>ติวเตอร์ที่ชื่นชอบ</h2>

    @if ($tutorFavorites->count() > 0)
        <div class="row g-4">
            @foreach ($tutorFavorites as $favorite)
                @php
                    $tutor = $favorite->favoritable;
                @endphp
                <div class="col-md-6 col-lg-4">
                    <div class="card favorite-card h-100">
                        <div class="card-body">
                            <h3 class="tutor-name">{{ $tutor->user->name }}</h3>
                            <p>คะแนน: {{ number_format($tutor->average_rating, 2) }}</p>
                            <p>ประสบการณ์: {{ $tutor->experience_years }} ปี</p>

                            <div class="d-flex gap-2">
                                <a href="{{ route('tutor.show', $tutor) }}" class="btn btn-primary">
                                    ดูข้อมูลติวเตอร์
                                </a>

                                <form action="{{ route('tutor.favorite.destroy', $tutor) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger">
                                        ลบออกจากรายการโปรด
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p>ยังไม่มีติวเตอร์ในรายการโปรด</p>
    @endif
</section>

<section class="favorite-section">
    <h2>วิชาที่ชื่นชอบ</h2>

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
                            <p>จำนวนติวเตอร์: {{ $subject->tutors->count() }} คน</p>

                            <div class="d-flex gap-2">
                                <a href="{{ route('tutor.search', ['search' => $subject->subject_name]) }}" class="btn btn-primary">
                                    ค้นหาติวเตอร์
                                </a>

                                <form action="{{ route('subject.favorite.destroy', $subject) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger">
                                        ลบออกจากรายการโปรด
                                    </button>
                                </form>
                            </div>
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