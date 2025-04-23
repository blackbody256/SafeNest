@extends('layouts.adminapp', ['activePage' => 'dashboard', 'title' => 'Admin Dashboard | Safe Nest Insurance System', 'navName' => 'Admin Dashboard', 'activeButton' => 'laravel'])


@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body text-center">
                <h2 class="font-weight-bold">Welcome to the Safe Nest Admin Dashboard</h2>
                <p class="lead">Hey 👋 {{ auth()->user()->name }}, here you can manage users, policies, claims, payments, and underwriters all in one place.</p>

                <p class="lead">Use the navigation menu on the left to access different sections of the admin panel.</p>
            </div>
        </div>

        {{-- You can add analytics or stats below if you like --}}
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card card-stats">
                    <div class="card-body">
                        <div class="numbers text-center">
                            <p class="card-category">Total Users</p>
                            <h4 class="card-title">{{ $userCount }}</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-stats">
                    <div class="card-body">
                        <div class="numbers text-center">
                            <p class="card-category">Active Policies</p>
                            <h4 class="card-title">{{ $policyCount }}</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-stats">
                    <div class="card-body">
                        <div class="numbers text-center">
                            <p class="card-category">Pending Claims</p>
                            <h4 class="card-title">{{ $claimCount }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

