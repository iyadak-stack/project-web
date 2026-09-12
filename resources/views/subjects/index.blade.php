<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>รายวิชาของฉัน</title>
</head>
<body>
    <h1>รายวิชาของฉัน</h1>

    <a href="{{ route('subjects.create') }}">+ เพิ่มวิชา</a>

    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <table border="1">
        <tr>
            <th>ชื่อวิชา</th>
            <th>จัดการ</th>
        </tr>
        @forelse ($subjects as $subject)
            <tr>
                <td>{{ $subject->subject_name }}</td>
                <td>
                    <a href="{{ route('subjects.edit', $subject) }}">แก้ไข</a>
                    <form action="{{ route('subjects.destroy', $subject) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit">ลบ</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="2">ยังไม่มีวิชา</td></tr>
        @endforelse
    </table>
</body>
</html>