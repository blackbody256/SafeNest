@extends('layouts.underwriterapp', ['activePage' => 'dashboard', 'title' => 'Light Bootstrap Dashboard Laravel by Creative Tim & UPDIVISION', 'navName' => 'Dashboard', 'activeButton' => 'laravel'])

@section('content')
<div class="content">
    <div class="container-fluid">

        {{-- Welcome Message --}}
        <div class="row mb-4">
            <div class="col-12">
            <div class="card text-white shadow" 
                style="background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)); border-radius: 0.75rem; min-height: 160px;">
                <div class="card-body d-flex flex-column justify-content-center align-items-center text-center">
                    <h3 class="mb-2 text-white fw-bold" style="font-size: 1.75rem;">
                        👋 Welcome, <strong>{{ Auth::user()->name }}</strong>
                    </h3>
                    <p class="mb-0 text-light" style="font-size: 1.2rem;">
                        You’re logged in as an underwriter. Monitor quotes, policies, and claims right here.
                    </p>
                </div>
            </div>



            </div>
        </div>

        {{-- Summary Cards --}}
        <div class="row">
            <div class="col-md-4">
                <div class="card card-stats card-hover">
                    <div class="card-body text-center">
                        <p class="card-category text-muted">Total Quotes</p>
                        <h4 class="card-title text-primary">{{ $totalQuotes }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-stats card-hover">
                    <div class="card-body text-center">
                        <p class="card-category text-muted">Approved Policies</p>
                        <h4 class="card-title text-success">{{ $approvedCount }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-stats card-hover">
                    <div class="card-body text-center">
                        <p class="card-category text-muted">Pending Claims</p>
                        <h4 class="card-title text-warning">{{ $pendingClaims }}</h4>
                    </div>
                </div>
            </div>
        </div>

        {{-- Approved Policies Table --}}
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="title mb-0">📄 Approved Policies</h5>
                        <small class="text-muted">Policies that have been approved and are currently active or expiring soon.</small>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>Policy ID</th>
                                    <th>User ID</th>
                                    <th>Status</th>
                                    <th>Expires At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($approvedPolicies as $policy)
                                <tr>
                                    <td>{{ $policy->Policy_ID }}</td>
                                    <td>{{ $policy->User_ID }}</td>
                                    <td>{{ $policy->Status }}</td>
                                    <td>{{ \Carbon\Carbon::parse($policy->expires_at)->format('Y/m/d') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">No approved policies yet.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection