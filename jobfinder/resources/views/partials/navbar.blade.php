<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="/dashboard">
            JobFinder Bandung
        </a>

        <ul class="navbar-nav ms-auto gap-3">
            <li class="nav-item">
                <a class="nav-link" href="/dashboard">Dashboard</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="/lamaran">Lamaran Saya</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="/profile">Profile</a>
            </li>

            <li class="nav-item">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-danger btn-sm">Logout</button>
                </form>
            </li>
        </ul>
    </div>
</nav>
