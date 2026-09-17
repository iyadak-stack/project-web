<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Tutor Profile</title>
</head>
<body>

    <h1>Edit Tutor Profile</h1>

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('tutor.profile.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label for="bio">Bio</label><br>
            <textarea id="bio" name="bio">{{ old('bio', $tutorProfile->bio) }}</textarea>
        </div>

        <br>

        <div>
            <label for="experience_years">Experience (years)</label><br>
            <input
                type="number"
                id="experience_years"
                name="experience_years"
                min="0"
                value="{{ old('experience_years', $tutorProfile->experience_years) }}"
            >
        </div>

        <br>

        <div>
            <label for="teaching_mode">Teaching Mode</label><br>

            <select id="teaching_mode" name="teaching_mode">
                <option value="online"
                    {{ old('teaching_mode', $tutorProfile->teaching_mode) === 'online' ? 'selected' : '' }}>
                    Online
                </option>

                <option value="onsite"
                    {{ old('teaching_mode', $tutorProfile->teaching_mode) === 'onsite' ? 'selected' : '' }}>
                    Onsite
                </option>

                <option value="both"
                    {{ old('teaching_mode', $tutorProfile->teaching_mode) === 'both' ? 'selected' : '' }}>
                    Both
                </option>
            </select>
        </div>

        <br>

        <button type="submit">Save</button>

        <a href="{{ route('tutor.profile') }}">Cancel</a>
    </form>

</body>
</html>