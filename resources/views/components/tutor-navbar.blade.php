<nav class="peer-navbar">
    <div class="peer-navbar-left">

        <a href="{{ route('home') }}"
           class="peer-logo {{ request()->routeIs('home') ? 'active' : '' }}">
            PeerTutor
        </a>

        <a href="{{ route('home') }}"
           class="peer-nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
            Home
        </a>

        <a href="{{ route('tutor.search') }}"
           class="peer-nav-link {{ request()->routeIs('tutor.search') ? 'active' : '' }}">
            Search Tutor/Subject
        </a>

        @auth
            <a href="{{ route('tutor.favorites') }}"
               class="peer-nav-link {{ request()->routeIs('tutor.favorites') ? 'active' : '' }}">
                Favorites
            </a>

            @if (auth()->user()->current_role === 'tutor')
                <a href="{{ route('tutor.profile') }}"
                   class="peer-nav-link {{ request()->routeIs('tutor.profile', 'tutor.show') ? 'active' : '' }}">
                    Tutor Profile
                </a>
            @else
                <a href="{{ route('student.profile') }}"
                   class="peer-nav-link {{ request()->routeIs('student.profile') ? 'active' : '' }}">
                    Student Profile
                </a>
            @endif

            <a href="{{ route('availabilities.index') }}" class="peer-nav-link {{ request()->routeIs('availabilities.*') ? 'active' : '' }}">
                My Schedule
            </a>
        @endauth
    </div>

    <div class="peer-navbar-right">
        @auth
            <span class="peer-role">
                {{ ucfirst(auth()->user()->current_role) }}
            </span>

            <form action="{{ route('role.switch') }}"
                  method="POST"
                  class="peer-role-form">

                @csrf
                <input
                    type="hidden"
                    name="role"
                    value="{{ auth()->user()->current_role === 'tutor' ? 'student' : 'tutor' }}"
                >
                <button type="submit" class="peer-switch">
                    Switch to {{ auth()->user()->current_role === 'tutor' ? 'Student' : 'Tutor' }}
                </button>
            </form>
        @else
            <a href="{{ route('login') }}" class="peer-switch">
                Login
            </a>
        @endauth
    </div>
</nav>