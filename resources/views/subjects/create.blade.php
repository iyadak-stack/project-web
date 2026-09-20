<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>เพิ่มวิชา</title>
</head>
<body>
    <h1>เพิ่มวิชาใหม่</h1>

    <form action="{{ route('subjects.store') }}" method="POST">
        @csrf

        <label>รหัสติวเตอร์ (tutor_id):</label><br>
        <input type="number" name="tutor_id" value="{{ old('tutor_id') }}"><br>
        @error('tutor_id') <p>{{ $message }}</p> @enderror

        <label>ชื่อวิชา:</label><br>
        <input type="text" name="subject_name" value="{{ old('subject_name') }}"><br>
        @error('subject_name') <p>{{ $message }}</p> @enderror

        <br>
        <button type="submit">บันทึก</button>
    </form>

    <a href="{{ route('subjects.index') }}">กลับ</a>
</body>
</html>