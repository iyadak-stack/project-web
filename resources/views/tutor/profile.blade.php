<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tutor Profile</title>
</head>
<body>
    <!-- Navigation Menu -->
    <x-tutor-navbar />
    
    <h1>Tutor Profile</h1>

    @if ($tutorProfile)
        <p>Bio: {{ $tutorProfile->bio }}</p>
        <p>Experience: {{ $tutorProfile->experience_years }} years</p>
        <p>Rating: {{ $tutorProfile->average_rating }}</p>
        <p>Teaching Mode: {{ $tutorProfile->teaching_mode }}</p>
        <br>

        <a href="{{ route('tutor.profile.edit') }}">
            <button type="button">Edit Profile</button>
        </a>
    @else
        <p>You don't have a tutor profile yet.</p>
    @endif

</body>
</html>