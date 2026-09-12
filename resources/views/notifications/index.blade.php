<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>การแจ้งเตือน</title>
</head>
<body>
    <h1>การแจ้งเตือน</h1>

    <table border="1">
        <tr>
            <th>ประเภท</th>
            <th>ข้อความ</th>
            <th>เวลา</th>
            <th>จัดการ</th>
        </tr>
        @forelse ($notifications as $notification)
            <tr>
                <td>{{ $notification->notification_type }}</td>
                <td>{{ $notification->message }}</td>
                <td>{{ $notification->created_at }}</td>
                <td>
                    <form action="{{ route('notifications.destroy', $notification) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit">ลบ</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="4">ยังไม่มีการแจ้งเตือน</td></tr>
        @endforelse
    </table>
</body>
</html>