<nav>
    <strong>♥ PeerTutor</strong>

    &nbsp; | &nbsp;

    <a href="{{ route('home') }}">Home</a>

    &nbsp; | &nbsp;

    <a href="{{ route('tutor.search') }}">
        Search Tutor/Subject
    </a>

    &nbsp; | &nbsp;
    <a href="{{ route('tutor.favorites') }}">
        Favorites
    </a>

    &nbsp; | &nbsp;
    @if (auth()->user()->current_role === 'tutor')
        <a href="{{ route('tutor.profile') }}">
            Tutor Profile
        </a>
    @else
        <a href="{{ route('student.profile') }}">
            Student Profile
        </a>

    @endif

    &nbsp; | &nbsp;
    <span>My Schedule</span>
    &nbsp; | &nbsp;
    <span>
        Current Role:
        {{ ucfirst(auth()->user()->current_role) }}
    </span>

    &nbsp; | &nbsp;
    <form
        action="{{ route('role.switch') }}"
        method="POST"
        style="display: inline;"
    >
        @csrf

        <input
            type="hidden"
            name="role"
            value="{{ auth()->user()->current_role === 'tutor' ? 'student' : 'tutor' }}"
        >
        <button type="submit">
            Switch to
            {{ auth()->user()->current_role === 'tutor' ? 'Student' : 'Tutor' }}
        </button>
    </form>
</nav>

<hr>