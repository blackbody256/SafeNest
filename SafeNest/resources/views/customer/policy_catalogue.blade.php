@extends('layouts.customerapp')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <h1>Policy Catalogue</h1>
            <p>Browse our available policies and submit an application.</p>
        </div>
    </div>
    
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    
    <div class="row">
        @forelse($policies as $policy)
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">{{ $policy->Title }}</h5>
                    <p class="card-text">{{ $policy->Description }}</p>
                    <p><strong>Premium:</strong> {{ $policy->Premium }}</p>
                    <p><strong>Duration:</strong> {{ \Carbon\Carbon::parse($policy->Duration)->format('Y/m/d') ?? 'N/A' }}</p>
                </div>
                <div class="card-footer">
                    <a href="{{ route('policy.application.form', $policy->Policy_ID) }}" class="btn btn-primary">Apply Now</a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info">
                No policies are available at the moment. Please check back later.
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection