<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tutor Ranking</title>
</head>
<body>
    <!-- Navigation Menu -->
    <x-tutor-navbar />

    <h1>Tutor Ranking</h1>

    <p>
        จัดอันดับติวเตอร์ตามคะแนนรีวิวและประสบการณ์
    </p>

    @if (session('success'))
        <p>
            {{ session('success') }}
        </p>
    @endif

    @if ($tutors->count() > 0)

        @foreach ($tutors as $index => $tutor)

            <div>
                <h2>
                    อันดับ {{ $index + 1 }}:
                    {{ $tutor->user->name ?? 'Unknown Tutor' }}
                </h2>

                <p>
                    Rating:
                    {{ $tutor->average_rating }}
                </p>

                <p>
                    Experience:
                    {{ $tutor->experience_years }} years
                </p>

                <p>
                    Teaching Mode:
                    {{ $tutor->teaching_mode }}
                </p>

                @php
                    $isFavorite = auth()->user()
                        ->favorites()
                        ->where('favoritable_type', \App\Models\TutorProfile::class)
                        ->where('favoritable_id', $tutor->id)
                        ->exists();
                @endphp

                @if ($isFavorite)

                    <form
                        action="{{ route('tutor.favorite.destroy', $tutor) }}"
                        method="POST"
                    >
                        @csrf
                        @method('DELETE')

                        <button type="submit">
                            ♥ Unfavorite
                        </button>
                    </form>

                @else

                    <form
                        action="{{ route('tutor.favorite.store', $tutor) }}"
                        method="POST"
                    >
                        @csrf

                        <button type="submit">
                            ♡ Favorite
                        </button>
                    </form>

                @endif

            </div>

            <hr>

        @endforeach

    @else

        <p>ยังไม่มีข้อมูลติวเตอร์</p>

    @endif

    <br>

    <a href="{{ route('tutor.search') }}">
        กลับไปหน้าค้นหาติวเตอร์
    </a>
    
</body>
</html>
