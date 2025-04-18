<footer class="footer">
    <div class="container @auth-fluid @endauth">
        <nav>
            <ul class="footer-menu">
                <li>
                    <a href="https://www.creative-tim.com" class="nav-link" target="_blank">{{ __('Group J') }}</a>
                </li>
                <li>
                    <a href="https://www.updivision.com" class="nav-link" target="_blank">{{ __('Github') }}</a>
                </li>
                <li>
                    <a href="{{ url('/') }}#about" class="nav-link" target="_blank">{{ __('About Us') }}</a>
                </li>
            </ul>
            <p class="copyright text-center">
                ©
                <script>
                    document.write(new Date().getFullYear())
                </script>
                <a href="http://www.creative-tim.com">{{ __('SafeNest.') }}</a> {{ __('All rights reserved.') }}
            </p>
        </nav>
    </div>
</footer>