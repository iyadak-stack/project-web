<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>นัดหมายของฉัน</title>
</head>
<body>
    <h1>นัดหมายของฉัน</h1>

    <a href="{{ route('appointments.create') }}">+ สร้างนัดใหม่</a>

    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <table border="1">
        <tr>
            <th>วิชา</th>
            <th>วันเวลา</th>
            <th>รูปแบบ</th>
            <th>สถานะ</th>
            <th>ดูรายละเอียด</th>
        </tr>
        @forelse ($appointments as $appointment)
            <tr>
                <td>{{ $appointment->subject->subject_name ?? '-' }}</td>
                <td>{{ $appointment->appointment_datetime->format('d/m/Y H:i') }}</td>
                <td>{{ $appointment->mode === 'online' ? 'ออนไลน์' : 'ออนไซต์' }}</td>
                <td>{{ $appointment->status }}</td>
                <td><a href="{{ route('appointments.show', $appointment) }}">ดู</a></td>
            </tr>
        @empty
            <tr><td colspan="5">ยังไม่มีนัดหมาย</td></tr>
        @endforelse
    </table>
</body>
</html>