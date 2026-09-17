<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search Tutor or Subject</title>
</head>
<body>

    <!-- Navigation Menu -->
    <x-tutor-navbar />

    <h1>Search Tutor or Subject</h1>

    <p>
        ค้นหาติวเตอร์หรือวิชาได้ที่นี่
    </p>

    <form action="{{ route('tutor.search') }}" method="GET">
        <input
            type="text"
            id="search"
            name="search"
            value="{{ $search }}"
            placeholder="พิมพ์ชื่อติวเตอร์ หรือชื่อวิชา..."
        >

        <button type="submit">
            ค้นหา
        </button>

    </form>

    @if ($search !== '')

        <hr>

        <h2>ผลการค้นหาติวเตอร์</h2>

        @if ($tutors->count() > 0)

            @foreach ($tutors as $tutor)

                <div>
                    <h3>
                        {{ $tutor->user->name ?? 'Unknown Tutor' }}
                    </h3>

                    <p>
                        Bio:
                        {{ $tutor->bio ?? 'No bio available' }}
                    </p>

                    <p>
                        Experience:
                        {{ $tutor->experience_years }} years
                    </p>

                    <p>
                        Rating:
                        {{ $tutor->average_rating }}
                    </p>

                    <p>
                        Teaching Mode:
                        {{ $tutor->teaching_mode }}
                    </p>
                </div>

                <hr>

            @endforeach

        @else

            <p>ไม่พบติวเตอร์</p>

        @endif


        <h2>ผลการค้นหาวิชา</h2>

        @if ($subjects->count() > 0)

            @foreach ($subjects as $subject)

                <div>
                    <h3>
                        {{ $subject->subject_name }}
                    </h3>

                    <p>
                        Subject ID:
                        {{ $subject->Subjec_id }}
                    </p>
                </div>

                <hr>

            @endforeach

        @else

            <p>ไม่พบวิชา</p>

        @endif

    @endif

</body>
</html>