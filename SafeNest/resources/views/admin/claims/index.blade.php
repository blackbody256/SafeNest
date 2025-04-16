@extends('layouts.adminapp', [
    'activePage' => 'claims',
    'title' => 'Claims Monitoring',
    'navName' => 'Claims Dashboard',
    'activeButton' => 'laravel'
])

@section('content')
<div class="content">
    <div class="container-fluid">
    <div class="row">
            <!-- User Statistics Cards -->
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5 col-md-4">
                                <div class="icon-big text-center icon-warning">
                                    <i class="nc-icon nc-single-02 text-primary"></i>
                                </div>
                            </div>
                            <div class="col-7 col-md-8">
                                <div class="numbers">
                                    <p class="card-category">Total Claims</p>
                                    <p class="card-title">{{ $totalClaims}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5 col-md-4">
                                <div class="icon-big text-center icon-warning">
                                    <i class="nc-icon nc-badge text-success"></i>
                                </div>
                            </div>
                            <div class="col-7 col-md-8">
                                <div class="numbers">
                                    <p class="card-category">Approved Claims</p>
                                    <p class="card-title">{{ $approvedClaims }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5 col-md-4">
                                <div class="icon-big text-center icon-warning">
                                    <i class="nc-icon nc-badge text-success"></i>
                                </div>
                            </div>
                            <div class="col-7 col-md-8">
                                <div class="numbers">
                                    <p class="card-category">Pending Claims</p>
                                    <p class="card-title">{{ $pendingClaims }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5 col-md-4">
                                <div class="icon-big text-center icon-warning">
                                    <i class="nc-icon nc-badge text-success"></i>
                                </div>
                            </div>
                            <div class="col-7 col-md-8">
                                <div class="numbers">
                                    <p class="card-category">Rejected Claims</p>
                                    <p class="card-title">{{ $rejectedClaims }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <!-- Recent Claims Table -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Recent Claims</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="text-primary">
                                    <tr>
                                        <th>Claim ID</th>
                                        <th>Policy ID</th>
                                        <th>Policy name</th>
                                        <th>User</th>
                                    
                                        <th>Status</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentClaims as $claim)
                                    <tr>
                                        <td>{{ $claim->id }}</td>
                                        <td>{{ $claim->policy->Policy_ID ?? 'N/A'}}</td>
                                        <td>{{ $claim->policy->Title ?? 'N/A'}}</td>
                                        <td>{{ $claim->user->name }}</td>
                                        
                                        <td>
    <span class="badge 
        @if(strtolower($claim->status) == 'approved') bg-success text-white
        @elseif(strtolower($claim->status) == 'rejected') bg-danger text-white
        @else bg-warning text-dark
        @endif">
        {{ ucfirst($claim->status) }}
    </span>
</td>

                                        <td>{{ $claim->created_at->format('M d, Y') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection