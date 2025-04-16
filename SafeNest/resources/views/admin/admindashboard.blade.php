@extends('layouts.adminapp', ['activePage' => 'dashboard', 'title' => 'Admin Dashboard | Safe Nest Insurance System', 'navName' => 'Admin Dashboard', 'activeButton' => 'laravel'])

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            {{-- User Management Card --}}
            <div class="col-md-6">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Manage Users</h5>
                        <p class="card-category">View users</p>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-primary">Go to Users</a>
                    </div>
                </div>
            </div>
            {{-- Policies Card --}}
            <div class="col-md-6">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Policies</h5>
                        <p class="card-category">View Policies and Policy Application</p>
                        <a href="{{ route('admin.policies') }}" class="btn btn-primary">Go to Policies</a>
                    </div>
                </div>
            </div>

            {{-- Claims Card --}}
            <div class="col-md-6">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Claims</h5>
                        <p class="card-category">View claims</p>
                        <a href="{{ route('admin.claims') }}" class="btn btn-primary">Manage Claims</a>
                    </div>
                </div>
            </div>

            {{-- Underwriters Card --}}
            <div class="col-md-6">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Underwriters</h5>
                        <p class="card-category">Create or manage underwriters</p>
                        <a href="{{ route('admin.underwriters.index') }}" class="btn btn-primary">Manage Underwriters</a>
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            

            {{-- Payments Card --}}
            <div class="col-md-6">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Payments</h5>
                        <p class="card-category">Monitor payments and logs</p>
                        <a href="{{ route('admin.payments') }}" class="btn btn-primary">View Payments</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@push('js')
    <script type="text/javascript">
        $(document).ready(function() {
            // Javascript method's body can be found in assets/js/demos.js
            demo.initDashboardPageCharts();

            demo.showNotification();

        });
    </script>
@endpush