<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>แก้ไขวิชา</title>
</head>
<body>
    <h1>แก้ไขวิชา</h1>

    <form action="{{ route('subjects.update', $subject) }}" method="POST">
        @csrf
        @method('PUT')

        <label>ชื่อวิชา:</label><br>
        <input type="text" name="subject_name" value="{{ old('subject_name', $subject->subject_name) }}"><br>
        @error('subject_name') <p>{{ $message }}</p> @enderror

        <br>
        <button type="submit">บันทึกการแก้ไข</button>
    </form>

    <a href="{{ route('subjects.index') }}">กลับ</a>
</body>
</html>