<div class="sidebar" data-image="{{ asset('light-bootstrap/img/sidebar-5.jpg') }}">
    <!--
    Tip 1: You can change the color of the sidebar using: data-color="purple | blue | green | orange | red"
    Tip 2: you can also add an image using data-image tag
    -->
    <div class="sidebar-wrapper">
        <div class="logo">
        <a href="{{ route('welcome') }}" class="simple-text" style="font-size: 1.5rem; font-weight: bold; color: #333; text-decoration: none; text-transform: none;">
                SafeNest<span style="color: white;">.</span>
            </a>
        </div>
        <ul class="nav">
            <li class="nav-item @if($activePage == 'dashboard') active @endif">
                <a class="nav-link" href="{{route('underwriterdashboard')}}">
                    <i class="nc-icon nc-chart-pie-36"></i>
                    <p>{{ __("Dashboard") }}</p>
                </a>
            </li>

            <li class="nav-item @if($activePage == 'user') active @endif">
                <a class="nav-link" href="{{route('profile.edit')}}">
                    <i class="nc-icon nc-single-02"></i>
                    <p>{{ __("User Profile") }}</p>
                </a>
            </li>

            <li class="nav-item @if(($activePage ?? '')=='policies') active @endif">
                <a class="nav-link" href="{{route('policies.index')}}">
                    <i class="nc-icon nc-single-copy-04"></i>
                    <p>{{ __("Policy") }}</p>
                </a>
            </li>

            <li class="nav-item @if($activePage == 'approve-policies') active @endif">
                <a class="nav-link" href="{{route('applications.index')}}">
                    <i class="nc-icon nc-notes"></i>
                    <p>{{ __("Approve Policies") }}</p>
                </a>
            </li>

            <li class="nav-item @if($activePage == 'approved-policies') active @endif">
                <a class="nav-link" href="{{route('approvedpolicies.index', 'typography')}}">
                    <i class="nc-icon nc-paper-2"></i>
                    <p>{{ __("Approved Policies") }}</p>
                </a>
            </li>

            <li class="nav-item @if($activePage == 'claims') active @endif">
                <a class="nav-link" href="{{route('claims.index')}}">
                    <i class="nc-icon nc-support-17"></i>
                    <p>{{ __("Manage Claims") }}</p>
                </a>
            </li>

            <li class="nav-item @if($activePage == 'quotes') active @endif">
                <a class="nav-link" href="{{ route('underwriter.quotes.index') }}">
                    <i class="nc-icon nc-money-coins"></i>
                    <p>{{ __("Quotes") }}</p>
                </a>
            </li>

            
        </ul>
    </div>
</div>
