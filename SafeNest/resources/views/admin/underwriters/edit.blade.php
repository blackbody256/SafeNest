@extends('layouts.adminapp', [
    'activePage' => 'underwriters',
    'title' => 'Underwriters',
    'navName' => 'Underwriters',
    'activeButton' => 'laravel'
])

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm rounded-3">
        <div class="card-body">
            <h1 class="card-title mb-4 fw-bold text-dark">Edit Underwriter</h1>

            <form action="{{ route('admin.underwriters.update', $underwriter) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input 
                        type="text" 
                        name="name" 
                        id="name" 
                        class="form-control bg-light text-muted" 
                        value="{{ $underwriter->user->name }}" 
                        disabled>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input 
                        type="email" 
                        name="email" 
                        id="email" 
                        class="form-control bg-light text-muted" 
                        value="{{ $underwriter->user->email }}" 
                        disabled>
                </div>

                <div class="mb-4">
                    <label for="commission_rate" class="form-label">Commission Rate (%)</label>
                    <input 
                        type="number" 
                        name="commission_rate" 
                        id="commission_rate" 
                        class="form-control" 
                        value="{{ $underwriter->commission_rate }}" 
                        min="0" 
                        max="100" 
                        required>
                </div>

                <div class="text-end">
                    <button 
                        type="submit" 
                        class="btn btn-primary px-4 py-2 shadow-sm">
                        Update Rate
                    </button>
                </div>
            </form>
        </div>
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
