<div class="col-md-2 sidebar py-3">
    <nav class="nav flex-column">
        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2"></i> Dashboard</a>
        <a class="nav-link {{ request()->routeIs('admin.tests*') || request()->routeIs('admin.sections*') || request()->routeIs('admin.questions*') ? 'active' : '' }}" href="{{ route('admin.tests') }}"><i class="bi bi-journal-text"></i> Manage Tests</a>
        <a class="nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}" href="{{ route('admin.users') }}"><i class="bi bi-people"></i> Users</a>
        <a class="nav-link {{ request()->routeIs('admin.results*') || request()->routeIs('admin.attempt*') ? 'active' : '' }}" href="{{ route('admin.results') }}"><i class="bi bi-clipboard-data"></i> Results</a>
    </nav>
</div>