@extends('layouts.tutor')
@section('title', 'โปรไฟล์ติวเตอร์')
@section('content')

<div class="profile-header">
    <h1>โปรไฟล์ติวเตอร์</h1>
    <p class="profile-description">ดูและจัดการข้อมูลโปรไฟล์ของคุณ</p>
</div>
@if ($tutorProfile)
<div class="card profile-card">
    <div class="card-body">
        <h2 class="section-title">ข้อมูลโปรไฟล์</h2>
        <div class="profile-info-grid">
            <div class="info-item">
                <span class="info-label">ประวัติ</span>
                <strong>{{ $tutorProfile->bio ?: 'ยังไม่มีข้อมูลประวัติ' }}</strong>
            </div>
            <div class="info-item">
                <span class="info-label">ประสบการณ์</span>
                <strong>{{ $tutorProfile->experience_years }} ปี</strong>
            </div>
            <div class="info-item">
                <span class="info-label">คะแนน</span>
                <strong>{{ number_format($tutorProfile->average_rating, 2) }} / 5.00</strong>
            </div>
            <div class="info-item">
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
        <div class="profile-actions">
            <a href="{{ route('tutor.profile.edit') }}" class="btn btn-primary">แก้ไขโปรไฟล์</a>
        </div>
    </div>
</div>
@else
<div class="empty-profile">
    <h2>ไม่พบโปรไฟล์ติวเตอร์</h2>
    <p>คุณยังไม่มีโปรไฟล์ติวเตอร์</p>
</div>
@endif
@endsection