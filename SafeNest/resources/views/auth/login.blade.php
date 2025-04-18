@extends('layouts/app', ['activePage' => 'login', 'title' => 'SafeNest'])

@section('content')
    <div class="full-page section-image" data-color="black" data-image="{{ asset('light-bootstrap/img/download.jpg') }}">
        <div class="content pt-5">
            <div class="container mt-5">    
                <div class="col-md-4 col-sm-6 ml-auto mr-auto">
                <form class="form" method="POST" action="{{ route('login') }}">
    @csrf
    <div class="card card-login card-hidden shadow-lg rounded-lg border-0">
        <div class="card-header">
            <h3 class="header text-center" style="font-size: 26px;">{{ __('Login') }}</h3>
        </div>
        <div class="card-body px-4 pt-3">
            <div class="form-group">
                <label for="email" class="col-form-label" style="font-size: 16px;">{{ __('E-Mail Address') }}</label>
                <input id="email" type="email"
                    class="form-control shadow-sm rounded @error('email') is-invalid @enderror"
                    name="email" value="{{ old('email', 'admin@lightbp.com') }}" required
                    autocomplete="email" autofocus>

                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password" class="col-form-label" style="font-size: 16px;">{{ __('Password') }}</label>
                <input id="password" type="password"
                    class="form-control shadow-sm rounded @error('password') is-invalid @enderror"
                    name="password" value="{{ old('password', 'secret') }}" required
                    autocomplete="current-password">

                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group mt-3">
                <div class="form-check">
                    <label class="form-check-label d-flex align-items-center" style="font-size: 15px;">
                        <input class="form-check-input mr-2" type="checkbox" name="remember" id="remember">
                        <span class="form-check-sign"></span>
                        {{ __('Remember me') }}
                    </label>
                </div>
            </div>
        </div>

        <div class="card-footer ml-auto mr-auto text-center pb-4">
            <button type="submit" class="btn btn-warning btn-wd shadow-sm px-5 py-2"
                style="font-size: 16px;">{{ __('Login') }}</button>

            <div class="d-flex justify-content-between mt-3 px-4">
                <a class="btn btn-link" style="color:#23CCEF; font-size: 14px;"
                    href="{{ route('password.request') }}">{{ __('Forgot password?') }}</a>
                <a class="btn btn-link" style="color:#23CCEF; font-size: 14px;"
                    href="{{ route('register') }}">{{ __('Create account') }}</a>
            </div>
        </div>
    </div>
</form>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            demo.checkFullPageBackgroundImage();

            setTimeout(function() {
                // after 1000 ms we add the class animated to the login/register card
                $('.card').removeClass('card-hidden');
            }, 700)
        });
    </script>
@endpush