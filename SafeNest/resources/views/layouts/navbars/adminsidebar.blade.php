<div class="sidebar" data-image="{{ asset('light-bootstrap/img/sidebar-5.jpg') }}">
    <div class="sidebar-wrapper">
        <div class="logo">
            <a href="http://www.creative-tim.com" class="simple-text">
                {{ __("Admin") }}
            </a>
        </div>
        <ul class="nav">
            <li class="nav-item @if($activePage == 'dashboard') active @endif">
                <a class="nav-link" href="{{ route('admindashboard') }}">
                    <i class="nc-icon nc-chart-pie-35"></i>
                    <p>{{ __("Dashboard") }}</p>
                </a>
            </li>

            <li class="nav-item @if($activePage == 'users') active @endif">
                <a class="nav-link" href="{{ route('admin.users.index') }}">
                    <i class="nc-icon nc-single-02"></i>
                    <p>{{ __("Manage Users") }}</p>
                </a>
            </li>

            <li class="nav-item @if($activePage == 'policies') active @endif">
                <a class="nav-link" href="{{ route('admin.policies') }}">
                    <i class="nc-icon nc-bullet-list-67"></i>
                    <p>{{ __("Policies") }}</p>
                </a>
            </li>

            <li class="nav-item @if($activePage == 'claims') active @endif">
                <a class="nav-link" href="{{ route('admin.claims') }}">
                    <i class="nc-icon nc-paper-2"></i>
                    <p>{{ __("Claims") }}</p>
                </a>
            </li>

            <li class="nav-item @if($activePage == 'underwriters') active @endif">
                <a class="nav-link" href="{{ route('admin.underwriters.index') }}">
                    <i class="nc-icon nc-badge"></i>
                    <p>{{ __("Underwriters") }}</p>
                </a>
            </li>

            <li class="nav-item @if($activePage == 'payments') active @endif">
                <a class="nav-link" href="{{ route('admin.payments') }}">
                    <i class="nc-icon nc-credit-card"></i>
                    <p>{{ __("Payments") }}</p>
                </a>
            </li>
        </ul>
    </div>
</div>
