<form action="{{ route('reports.store') }}" method="POST" enctype="multipart/form-data">

    @csrf

    <h2>รายงาน</h2>

    <p>เหตุใดคุณจึงรายงาน</p>

    @foreach ($reasons as $reason)
        <label>
            <input
                type="radio"
                name="reason_id"
                value="{{ $reason->Reason_id }}"
                required
            >

            {{ $reason->reason_name }}
        </label>
    @endforeach

    <p>รายละเอียดการรายงาน</p>

    <textarea name="description"></textarea>

    <input type="file" name="evidence">

    <button type="submit">
        เรียบร้อย
    </button>

</form>