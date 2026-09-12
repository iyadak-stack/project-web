<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>สร้างนัดหมายใหม่</title>
</head>
<body>
    <h1>สร้างนัดหมายใหม่</h1>

    <form action="{{ route('appointments.store') }}" method="POST">
        @csrf

        <label>รหัสนักเรียน (student_id):</label><br>
        <input type="number" name="student_id" value="{{ old('student_id') }}"><br>
        @error('student_id') <p>{{ $message }}</p> @enderror

        <label>รหัสติวเตอร์ (tutor_id):</label><br>
        <input type="number" name="tutor_id" value="{{ old('tutor_id') }}"><br>
        @error('tutor_id') <p>{{ $message }}</p> @enderror

        <label>รหัสวิชา (subject_id):</label><br>
        <input type="number" name="subject_id" value="{{ old('subject_id') }}"><br>
        @error('subject_id') <p>{{ $message }}</p> @enderror

        <label>รูปแบบ:</label><br>
        <select name="mode">
            <option value="online">ออนไลน์</option>
            <option value="onsite">ออนไซต์</option>
        </select><br>
        @error('mode') <p>{{ $message }}</p> @enderror

        <label>รหัสสถานที่ (location_id) — ใส่เมื่อออนไซต์เท่านั้น:</label><br>
        <input type="number" name="location_id" value="{{ old('location_id') }}"><br>
        @error('location_id') <p>{{ $message }}</p> @enderror

        <label>วันเวลานัดหมาย:</label><br>
        <input type="datetime-local" name="appointment_datetime" value="{{ old('appointment_datetime') }}"><br>
        @error('appointment_datetime') <p>{{ $message }}</p> @enderror

        <br>
        <button type="submit">สร้างนัดหมาย</button>
    </form>

    <a href="{{ route('appointments.index') }}">กลับ</a>
</body>
</html>