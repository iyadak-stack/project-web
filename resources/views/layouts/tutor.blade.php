<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>
        PeerTutor: @yield('title', 'Tutor')
    </title>
</head>
<body>
    <x-tutor-navbar />
    <main>
        @yield('content')
    </main>
</body>
</html>