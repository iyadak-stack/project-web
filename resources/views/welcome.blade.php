@extends('layouts.tutor')
@section('title', 'หน้าหลัก')
@section('content')

<div class="home-hero">
    <div>
        <h1>ยินดีต้อนรับสู่ PeerTutor</h1>
        <p>ค้นหาติวเตอร์ ค้นหาวิชา และจัดการการเรียนของคุณ</p>
        <a href="{{ route('tutor.search') }}" class="btn btn-primary">ค้นหาติวเตอร์ / วิชา</a>
    </div>
</div>

<section class="home-section">
    <div class="section-header">
        <div>
            <h2>ติวเตอร์คะแนนสูง</h2>
            <p>ดูติวเตอร์ที่มีคะแนนสูง</p>
        </div>
        <a href="{{ route('tutor.ranking') }}" class="btn btn-outline-primary">ดูอันดับติวเตอร์</a>
    </div>

    @if ($topTutors->count() > 0)
        <div class="row g-4">
            @foreach ($topTutors as $tutor)
                <div class="col-md-6 col-lg-4">
                    <div class="card tutor-card h-100">
                        <div class="card-body">
                            <div class="tutor-rank">อันดับ #{{ $loop->iteration }}</div>
                            <h3 class="tutor-name">{{ $tutor->user->name ?? 'ไม่พบชื่อติวเตอร์' }}</h3>

                            <div class="tutor-info">
                                <strong>คะแนน</strong>
                                <span>{{ number_format($tutor->average_rating, 2) }} / 5.00</span>
                            </div>

                            <div class="tutor-info">
                                <strong>ประสบการณ์</strong>
                                <span>{{ $tutor->experience_years }} ปี</span>
                            </div>

                            <div class="tutor-info">
                                <strong>รูปแบบการสอน</strong>
                                <span>
                                    @if ($tutor->teaching_mode === 'online')
                                        ออนไลน์
                                    @elseif ($tutor->teaching_mode === 'onsite')
                                        ออนไซด์
                                    @else
                                        ออนไลน์และออนไซด์
                                    @endif
                                </span>
                            </div>

                            <div class="tutor-subjects">
                                <strong>วิชาที่สอน</strong>
                                <div class="mt-2">
                                    @if ($tutor->subjects->count() > 0)
                                        @foreach ($tutor->subjects as $subject)
                                            <span class="badge bg-light text-dark border me-1 mb-1">
                                                {{ $subject->subject_name }}
                                            </span>
                                        @endforeach
                                    @else
                                        <span class="text-muted">ยังไม่มีวิชาที่สอน</span>
                                    @endif
                                </div>
                            </div>

                            <div class="mt-4">
                                <a href="{{ route('tutor.show', $tutor) }}" class="btn btn-primary w-100">
                                    ดูข้อมูลติวเตอร์
                                </a>
                            </div>

                            @auth
                                <form action="{{ route('tutor.favorite.store', $tutor) }}" method="POST" class="mt-2">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger w-100">
                                        ♡ เพิ่มในรายการโปรด
                                    </button>
                                </form>
                            @endauth
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-secondary">ขณะนี้ยังไม่มีข้อมูลติวเตอร์</div>
    @endif
</section>

<section class="home-section">
    <div class="section-header">
        <div>
            <h2>วิชาที่เปิดสอน</h2>
            <p>ดูวิชาที่มีติวเตอร์เปิดสอนอยู่ในขณะนี้</p>
        </div>
        <a href="{{ route('tutor.search') }}" class="btn btn-outline-primary">ค้นหาวิชา</a>
    </div>

    @if ($topSubjects->count() > 0)
        <div class="row g-4">
            @foreach ($topSubjects as $subject)
                <div class="col-md-6 col-lg-4">
                    <div class="card subject-card h-100">
                        <div class="card-body">
                            <div class="subject-rank">อันดับ #{{ $loop->iteration }}</div>
                            <h3 class="subject-name">{{ $subject->subject_name }}</h3>
                            <p class="text-muted mb-0">
                                จำนวนติวเตอร์:
                                <strong>{{ $subject->tutors->count() }}</strong> คน
                            </p>

                            @auth
                                <form action="{{ route('subject.favorite.store', $subject) }}" method="POST" class="mt-3">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger w-100">
                                        ♡ เพิ่มในรายการโปรด
                                    </button>
                                </form>
                            @endauth
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-secondary">ขณะนี้ยังไม่มีข้อมูลวิชา</div>
    @endif
</section>

<section class="home-section">
    <div class="section-header">
        <div>
            <h2>บทเรียนที่กำลังจะมาถึง</h2>
            <p>การเรียนที่กำลังจะมาถึงจะแสดงที่นี่</p>
        </div>
    </div>

    <div class="card upcoming-card">
        <div class="card-body">
            <p class="mb-0 text-muted">
                ส่วนนี้จะเชื่อมกับระบบการนัดหมายและตารางเวลาของกลุ่มในภายหลัง
            </p>
        </div>
    </div>
</section>
@endsection