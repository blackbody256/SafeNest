<div class="sidebar" data-image="{{ asset('light-bootstrap/img/sidebar-5.jpg') }}">
    <!--
Tip 1: You can change the color of the sidebar using: data-color="purple | blue | green | orange | red"

Tip 2: you can also add an image using data-image tag
-->
    <div class="sidebar-wrapper">
        <div class="logo" style="text-align: center; padding: 20px 0;">
            <a href="{{ route('welcome') }}" class="simple-text" style="font-size: 1.5rem; font-weight: bold; color: #333; text-decoration: none; text-transform: none;">
                SafeNest<span style="color: white;">.</span>
            </a>
        </div>

        <ul class="nav">
            <li class="nav-item @if($activePage == 'dashboard') active @endif">
                <a class="nav-link" href="{{route('customerdashboard')}}">
                    <i class="nc-icon nc-chart-pie-36"></i>
                    <p>{{ __("Dashboard") }}</p>
                </a>
            </li>
           
           

            <li class="nav-item">
                <a class="nav-link" href="{{route('profile.edit')}}">
                    <i class="nc-icon nc-single-02"></i>
                    <p>{{ __("User Profile") }}</p>
                </a>
            </li>

            <li class="nav-item @if($activePage == 'My Policies') active @endif">
                            <a class="nav-link" href="{{route('mypolicies') }}">
                                <i class="nc-icon nc-single-copy-04"></i>
                                <p>{{ __("My Policies") }}</p>
                            </a>
            </li>




            <li class="nav-item @if($activePage == 'policy.catalogue') active @endif">
                <a class="nav-link" href="{{route('policy.catalogue')}}">
                    <i class="nc-icon nc-bullet-list-67"></i>
                    <p>{{ __("Policy Catalogue") }}</p>
                </a>
            </li>

            <li class="nav-item @if($activePage == 'my.applications') active @endif">
                <a class="nav-link" href="{{route('my.applications')}}">
                    <i class="nc-icon nc-paper-2"></i>
                    <p>{{ __("My applications") }}</p>
                </a>
            </li>
            <li class="nav-item @if($activePage == 'mypayments') active @endif">
                <a class="nav-link {{ $activePage == 'mypayments' ? 'active' : '' }}" href="{{ route('customer.payments') }}">
                    <i class="nc-icon nc-money-coins"></i>
                    <p>{{ __('My Payments') }}</p>
                </a>
            </li>
           
            <li class="nav-item @if($activePage == 'claims') active @endif">
                <a class="nav-link" href="{{route('customer.claims.index')}}">
                    <i class="nc-icon nc-support-17"></i>
                    <p>{{ __("Claims") }}</p>
                </a>
            </li>
        </ul>
    </div>
</div>
