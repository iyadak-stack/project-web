@extends('layouts.tutor')

@section('title', 'ค้นหาติวเตอร์หรือวิชา')

@section('content')

<div class="search-header">
    <h1>ค้นหาติวเตอร์หรือวิชา</h1>
    <p>ค้นหาติวเตอร์หรือวิชาที่ต้องการ</p>
</div>

<div class="search-box">
    <form action="{{ route('tutor.search') }}" method="GET">
        <div class="row g-2">
            <div class="col-md-10">
                <input
                    type="text"
                    name="search"
                    value="{{ $search }}"
                    class="form-control"
                    placeholder="ค้นหาติวเตอร์หรือวิชา..."
                >
            </div>

            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">
                    ค้นหา
                </button>
            </div>
        </div>
    </form>
</div>

@if ($search !== '')

<div class="results-header">
    <h2>ผลการค้นหา</h2>
    <p>คำค้นหา: <strong>"{{ $search }}"</strong></p>
</div>

{{-- แสดง Tutor --}}
@if ($tutors->count() > 0)

<section class="result-section">
    <div class="section-section-title">
        <h3>ติวเตอร์</h3>
        <span class="result-count">{{ $tutors->count() }} คน</span>
    </div>

    <div class="row g-4">

        @foreach ($tutors as $tutor)
        <div class="col-md-6 col-lg-4">
            <div class="card tutor-card h-100">
                <div class="card-body">
                    <h4 class="tutor-name">{{ $tutor->user->name ?? 'ไม่พบชื่อติวเตอร์' }}</h4>

                    <p>
                        <strong>คะแนน:</strong>
                        {{ number_format($tutor->average_rating, 2) }} / 5.00
                    </p>

                    <p>
                        <strong>ประสบการณ์:</strong>
                        {{ $tutor->experience_years }} ปี
                    </p>

                    <p>
                        <strong>รูปแบบการสอน:</strong>

                        @if ($tutor->teaching_mode === 'online')
                            ออนไลน์
                        @elseif ($tutor->teaching_mode === 'onsite')
                            สถานที่
                        @else
                            ออนไลน์และสถานที่
                        @endif
                    </p>

                    <p>
                        <strong>ประวัติ:</strong>
                        {{ $tutor->bio ?? 'ยังไม่มีข้อมูลประวัติ' }}
                    </p>

                    <p>
                        <strong>วิชาที่สอน:</strong>
                    </p>

                    @if ($tutor->subjects->count() > 0)
                        @foreach ($tutor->subjects as $subject)
                            <span class="badge bg-light text-dark border me-1 mb-1">
                                {{ $subject->subject_name }}
                            </span>
                        @endforeach

                    @else
                        <p>ยังไม่มีวิชาที่สอน</p>
                    @endif

                    <div class="mt-3">
                        <a
                            href="{{ route('tutor.show', $tutor) }}"
                            class="btn btn-primary w-100"
                        >
                            ดูข้อมูลติวเตอร์
                        </a>

                        <form
                            action="{{ route('tutor.favorite.store', $tutor) }}"
                            method="POST"
                            class="mt-2"
                        >
                            @csrf

                            <button
                                type="submit"
                                class="btn btn-outline-danger w-100"
                            >
                                ♡ เพิ่มในรายการโปรด
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>

@endif

{{-- แสดง Subject --}}
@if ($subjects->count() > 0)

<section class="result-section">
    <div class="section-title">
        <h3>วิชา</h3>
        <span class="result-count">{{ $subjects->count() }} วิชา</span>
    </div>

    <div class="row g-4">
        @foreach ($subjects as $subject)
        <div class="col-md-6 col-lg-4">
            <div class="card subject-card h-100">
                <div class="card-body">
                    <h4 class="subject-name">{{ $subject->subject_name }}</h4>
                    <p>
                        <strong>จำนวนติวเตอร์:</strong>
                        {{ $subject->tutors->count() }} คน
                    </p>

                    @if ($subject->tutors->count() > 0)
                        <p><strong>ติวเตอร์:</strong></p>
                        @foreach ($subject->tutors as $tutor)
                            <div class="tutor-result">
                                <a
                                    href="{{ route('tutor.show', $tutor) }}"
                                    class="tutor-link"
                                >
                                    {{ $tutor->user->name ?? 'ไม่พบชื่อติวเตอร์' }}
                                </a>

                                <span class="text-muted">
                                    คะแนน {{ number_format($tutor->average_rating, 2) }}
                                </span>
                            </div>
                        @endforeach
                    @else
                        <p>ยังไม่มีติวเตอร์สำหรับวิชานี้</p>
                    @endif
                    <form
                        action="{{ route('subject.favorite.store', $subject) }}"
                        method="POST"
                        class="mt-3"
                    >
                        @csrf

                        <button
                            type="submit"
                            class="btn btn-outline-danger w-100"
                        >
                            ♡ เพิ่มวิชาในรายการโปรด
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>

@endif

{{-- ไม่พบข้อมูล --}}
@if ($tutors->count() === 0 && $subjects->count() === 0)

<div class="alert alert-secondary no-results">
    ไม่พบติวเตอร์หรือวิชาที่ตรงกับคำค้นหา
</div>

@endif

@endif

@endsection