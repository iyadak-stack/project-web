@extends('layouts.tutor')
@section('title', 'การจองติวเตอร์')
@section('content')
<div class="page-header">
    <h1>รายละเอียดการจอง</h1>
    <p class="page-description">ตรวจสอบข้อมูลการจองก่อนยืนยัน</p>
</div>
<div class="card profile-card">
    <div class="card-body">
        <h2>ติวเตอร์</h2>
        <p>{{ $tutorProfile->user->name ?? 'ไม่พบชื่อติวเตอร์' }}</p>

        <h2>วันและเวลา</h2>
        <p>วันที่: {{ $selectedAvailability->start_datetime->format('d/m/Y') }}</p>
        <p>เวลา: {{ $selectedAvailability->start_datetime->format('H:i') }} - {{ $selectedAvailability->end_datetime->format('H:i') }}</p>

        <h2>เลือกวิชา</h2>
        <form action="{{ route('tutor.book.save', ['tutorProfile' => $tutorProfile, 'availability' => $selectedAvailability]) }}" method="POST">
            @csrf

            <select name="subject_id" class="form-control" required>
                <option value="">-- เลือกวิชา --</option>
                @foreach ($tutorProfile->subjects as $subject)
                    <option value="{{ $subject->Subjec_id }}">{{ $subject->subject_name }}</option>
                @endforeach
            </select>

            <button type="submit" class="btn btn-primary mt-3">
                ยืนยันการจอง
            </button>

            <a href="{{ route('tutor.show', $tutorProfile) }}" class="btn btn-secondary mt-3">
                ย้อนกลับ
            </a>
        </form>
    </div>
</div>
@endsection