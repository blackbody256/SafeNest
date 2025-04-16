@extends('layouts.adminapp', [
    'activePage' => 'policies',
    'title' => 'Policy Monitoring',
    'navName' => 'Policy Activity',
    'activeButton' => 'laravel'
])


@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- Policy Statistics Cards -->
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
                                    <p class="card-category">Total Policies</p>
                                    <p class="card-title">{{ $totalPolicies }}</p>
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
                                    <p class="card-category">Policy Applications</p>
                                    <p class="card-title">{{ $totalApplications }}</p>
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
                                    <p class="card-category">Appproved Policies</p>
                                    <p class="card-title">{{ $approvedPolicies }}</p>
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
                                    <p class="card-category">Pending Policies</p>
                                    <p class="card-title">{{ $pendingPolicies }}</p>
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
                                    <p class="card-category">Rejected Policies</p>
                                    <p class="card-title">{{ $rejectedPolicies }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            
            <!-- Recent Policy Activity Table -->

            <!-- Recent Policy Activity Table -->
<div class="col-md-12 mb-4">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Recent Policy Activity</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="text-primary">
                        <tr>
                            <th>Policy ID</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentPolicies as $policy)
                        <tr>
                            <td>{{ $policy->Policy_ID }}</td>
                            <td>{{ $policy->Title }}</td>
                            <td>{{ $policy->Description }}</td>
                            <td>{{ $policy->created_at->diffForHumans() }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



            
            <!-- Recent Policy Applications Table -->
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Recent Policy Applications</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="text-primary">
                        <tr>
                            <th>Application ID</th>
                            <th>User</th>
                            <th>Policy</th>
                            <th>Status</th>
                            <th>Date Applied</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentApplications as $application)
                        <tr>
                            <td>{{ $application->Application_ID }}</td>
                            <td>{{ $application->user->name ?? 'N/A' }}</td>
                            <td>{{ $application->policy->Title ?? 'N/A' }}</td>
                            <td>
                                <span class="badge 
                                    @if($application->Status == 'Approved') bg-success 
                                    @elseif($application->Status == 'Rejected') bg-danger 
                                    @else bg-warning text-dark @endif">
                                    {{ $application->Status }}
                                </span>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($application->Date_Applied)->diffForHumans() }}</td>
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