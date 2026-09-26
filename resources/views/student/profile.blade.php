@extends('layouts.tutor')
@section('title', 'โปรไฟล์นักเรียน')
@section('content')

<h1>โปรไฟล์นักเรียน</h1>

@if (session('success'))
    <p>{{ session('success') }}</p>
@endif

<p>ชื่อ: {{ auth()->user()->name }}</p>

@if ($studentProfile)
    <p>ประวัติ: {{ $studentProfile->bio ?? 'ยังไม่มีข้อมูลประวัติ' }}</p>
@else
    <p>คุณยังไม่มีโปรไฟล์นักเรียน</p>
@endif

<a href="{{ route('student.profile.edit') }}">
    <button type="button">แก้ไขโปรไฟล์</button>
</a>
@endsection