@extends('layouts.tutor')
@section('title', 'แก้ไขโปรไฟล์นักเรียน')
@section('content')

<h1>แก้ไขโปรไฟล์นักเรียน</h1>

@if ($errors->any())
    <div>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form action="{{ route('student.profile.update') }}" method="POST">
    @csrf
    <div>
        <label for="bio">ประวัติ</label>
        <br>
        <textarea id="bio" name="bio" rows="5">{{ old('bio', $studentProfile->bio ?? '') }}</textarea>
    </div>
    <br>
    <button type="submit">บันทึก</button>

    <a href="{{ route('student.profile') }}">ยกเลิก</a>
</form>
@endsection
