<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>รายละเอียดนัดหมาย</title>
</head>
<body>
    <h1>รายละเอียดนัดหมาย</h1>

    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <p>วิชา: {{ $appointment->subject->subject_name ?? '-' }}</p>
    <p>วันเวลา: {{ $appointment->appointment_datetime->format('d/m/Y H:i') }}</p>
    <p>รูปแบบ: {{ $appointment->mode === 'online' ? 'ออนไลน์' : 'ออนไซต์' }}</p>
    @if($appointment->location)
        <p>สถานที่: {{ $appointment->location->location_name }}</p>
    @endif
    <p>สถานะ: {{ $appointment->status }}</p>

    <form action="{{ route('appointments.confirm', $appointment) }}" method="POST">
        @csrf
        <button type="submit">ยืนยันนัดหมาย</button>
    </form>

    <form action="{{ route('appointments.cancel', $appointment) }}" method="POST">
        @csrf
        <button type="submit">ยกเลิกนัดหมาย</button>
    </form>

    <form action="{{ route('appointments.reschedule', $appointment) }}" method="POST">
        @csrf
        <label>เลื่อนนัดไปวันเวลาใหม่:</label><br>
        <input type="datetime-local" name="appointment_datetime"><br>
        <button type="submit">เลื่อนนัด</button>
    </form>

    <a href="{{ route('appointments.index') }}">กลับ</a>
</body>
</html>