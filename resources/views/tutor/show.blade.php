@extends('layouts.tutor')
@section('title', 'รายละเอียดติวเตอร์')
@section('content')
<div class="page-header">
    <h1>{{ $tutorProfile->user->name ?? 'ไม่พบชื่อติวเตอร์' }}</h1>
    <p class="page-description">ดูข้อมูลติวเตอร์ วิชาที่สอน เวลาที่ว่าง และการจอง</p>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card profile-card mb-4">
            <div class="card-body">
                <h2 class="section-title">ข้อมูลติวเตอร์</h2>
                <div class="info-grid">
                    <div class="info-box">
                        <span class="info-label">คะแนน</span>
                        <strong>{{ number_format($tutorProfile->average_rating, 2) }} / 5.00</strong>
                    </div>
                    <div class="info-box">
                        <span class="info-label">ประสบการณ์</span>
                        <strong>{{ $tutorProfile->experience_years }} ปี</strong>
                    </div>
                    <div class="info-box">
                        <span class="info-label">รูปแบบการสอน</span>
                        <strong>
                            @if ($tutorProfile->teaching_mode === 'online')
                                ออนไลน์
                            @elseif ($tutorProfile->teaching_mode === 'onsite')
                                ออนไซด์
                            @else
                                ออนไลน์และออนไซด์
                            @endif
                        </strong>
                    </div>
                </div>

                <hr>

                <h2 class="section-title">เกี่ยวกับติวเตอร์</h2>
                <p class="about-description">
                    {{ $tutorProfile->bio ?? 'ยังไม่มีข้อมูลประวัติ' }}
                </p>

                <hr>

                <h2 class="section-title">วิชาที่สอน</h2>
                @if ($tutorProfile->subjects->count() > 0)
                    <div class="subject-list">
                        @foreach ($tutorProfile->subjects as $subject)
                            <span class="subject-tag">{{ $subject->subject_name }}</span>
                        @endforeach
                    </div>
                @else
                    <p class="empty-text">ยังไม่มีวิชาที่สอน</p>
                @endif
            </div>
        </div>

        <div class="card profile-card mb-4">
            <div class="card-body">
                <h2 class="section-title">เวลาที่เปิดให้จอง</h2>
                @if ($availabilities->count() > 0)
                    @foreach ($availabilities as $availability)
                        <div class="available-time">
                            <p>
                                <strong>วันที่:</strong>
                                {{ $availability->start_datetime->format('d/m/Y') }}
                            </p>
                            <p>
                                <strong>เวลา:</strong>
                                {{ $availability->start_datetime->format('H:i') }} -
                                {{ $availability->end_datetime->format('H:i') }}
                            </p>
                        </div>
                    @endforeach
                @else
                    <div class="available-time">
                        <p>ขณะนี้ยังไม่มีเวลาที่เปิดให้จอง</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card profile-card favorite-box">
            <div class="card-body">
                <h2 class="section-title">รายการโปรด</h2>
                @if ($isFavorite)
                    <p class="favorite-text">ติวเตอร์คนนี้อยู่ในรายการโปรดของคุณแล้ว</p>
                    <form action="{{ route('tutor.favorite.destroy', $tutorProfile) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger w-100">
                            ลบออกจากรายการโปรด
                        </button>
                    </form>
                @else
                    <p class="favorite-text">บันทึกติวเตอร์คนนี้ไว้ในรายการโปรด</p>
                    <form action="{{ route('tutor.favorite.store', $tutorProfile) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-primary w-100">
                            เพิ่มในรายการโปรด
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="back-section">
    <a href="{{ route('tutor.search') }}" class="back-link">
        กลับไปหน้าค้นหา
    </a>
</div>
@endsection