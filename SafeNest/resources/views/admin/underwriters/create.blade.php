@extends('layouts.adminapp', [
    'activePage' => 'underwriters',
    'title' => 'Underwriters',
    'navName' => 'Underwriters',
    'activeButton' => 'laravel'
])

@section('content')
<div class="container">
    <h1 class="card-title mb-4 fw-bold text-dark">Create Underwriter</h1>

    <div class="card shadow-sm p-4">

        {{-- Error messages --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.underwriters.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="commission_rate" class="form-label">Commission Rate (%)</label>
                <input type="number" name="commission_rate" id="commission_rate" class="form-control" value="{{ old('commission_rate', '5.00') }}" min="0" max="100">
            </div>

            <button type="submit" class="btn btn-primary">Create Underwriter</button>
        </form>
    </div>
</div>
<style>
    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        color: #fff;
    }
    .btn-primary:hover {
        border-color: #004085;
    }
</style>
@endsection
