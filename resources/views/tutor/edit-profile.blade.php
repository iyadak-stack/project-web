@extends('layouts.tutor')
@section('title', 'แก้ไขโปรไฟล์ติวเตอร์')
@section('content')
<div class="profile-header">
    <h1>แก้ไขโปรไฟล์ติวเตอร์</h1>
    <p class="profile-description">แก้ไขข้อมูลโปรไฟล์ของคุณ</p>
</div>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="card profile-card">
    <div class="card-body">
        <form action="{{ route('tutor.profile.update') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="bio" class="form-label">ประวัติ</label>
                <textarea id="bio" name="bio" class="form-control" rows="5">{{ old('bio', $tutorProfile->bio ?? '') }}</textarea>
            </div>
            <div class="mb-3">
                <label for="experience_years" class="form-label">ประสบการณ์ (ปี)</label>
                <input type="number" id="experience_years" name="experience_years" class="form-control" min="0" value="{{ old('experience_years', $tutorProfile->experience_years ?? 0) }}">
            </div>
            <div class="mb-4">
                <label for="teaching_mode" class="form-label">รูปแบบการสอน</label>
                <select id="teaching_mode" name="teaching_mode" class="form-select">
                    <option value="online" {{ old('teaching_mode', $tutorProfile->teaching_mode ?? '') === 'online' ? 'selected' : '' }}>ออนไลน์</option>
                    <option value="onsite" {{ old('teaching_mode', $tutorProfile->teaching_mode ?? '') === 'onsite' ? 'selected' : '' }}>สถานที่</option>
                    <option value="both" {{ old('teaching_mode', $tutorProfile->teaching_mode ?? '') === 'both' ? 'selected' : '' }}>ออนไลน์และสถานที่</option>
                </select>
            </div>
            <div class="profile-actions">
                <button type="submit" class="btn btn-primary">บันทึก</button>
                <a href="{{ route('tutor.profile') }}" class="btn btn-outline-secondary">ยกเลิก</a>
            </div>
        </form>
    </div>
</div>
@endsection