@extends('layouts.app', ['activePage' => 'register', 'title' => 'SafeNest'])

@section('content')
    <div class="full-page register-page section-image" data-color="black" data-image="{{ asset('light-bootstrap/img/register2.jpg') }}">
        <div class="content">
            <div class="container">
                <div class="card card-register card-plain text-center">
                    <div class="card-body ">
                    <div class="row justify-content-center">
    <div class="col-md-6">
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="card card-plain shadow-lg rounded">
                <div class="content p-4">
                    <h5 class="text-white mb-4 font-weight-bold">Create Your Account</h5>

                    <div class="form-group">
                        <input type="text" name="name" id="name" class="form-control rounded-pill shadow-sm px-4" placeholder="{{ __('Name') }}" value="{{ old('name') }}" required autofocus>
                    </div>

                    <div class="form-group">
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="Enter email" class="form-control rounded-pill shadow-sm px-4" required>
                    </div>

                    <div class="form-group">
                        <input type="password" name="password" class="form-control rounded-pill shadow-sm px-4" placeholder="Password" required>
                    </div>

                    <div class="form-group">
                        <input type="password" name="password_confirmation" class="form-control rounded-pill shadow-sm px-4" placeholder="Confirm Password" required>
                    </div>

                    <div class="form-check rounded col-md-10 text-left">
                                                    <label class="form-check-label text-white d-flex align-items-center">
                                                        <input class="form-check-input" name="agree" type="checkbox" required >
                                                        <span class="form-check-sign"></span>
                                                        <b>{{ __('Agree with terms and conditions') }}</b>
                                                    </label>
                                                </div>

                    <div class="footer text-center">
                        <button type="submit" class="btn btn-warning btn-round btn-lg shadow-sm px-5 py-2">{{ __('Create Free Account') }}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="col-md-8 mt-5">
        <div class="media d-flex justify-content-center align-items-center">
            <div class="icon text-white mr-3">
                <i class="nc-icon nc-circle-09" style="font-size: 30px;"></i>
            </div>
            <div class="media-body text-white">
                <h4 class="mb-1">{{ __('Customer Registrations') }}</h4>
                <p class="mb-0">{{ __('Account registration is available exclusively for customers.') }}</p>
            </div>
        </div>
    </div>

    <div class="col-md-8 mt-3">
        @foreach ($errors->all() as $error)
            <div class="alert alert-warning alert-dismissible fade show" >
                <a href="#" class="close" data-dismiss="alert" aria-label="close"> &times;</a>
                {{ $error }}
            </div>
        @endforeach
    </div>
</div>

                    </div>
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