@extends('layouts.customerapp', ['activePage' => 'My payments', 'title' => 'My Payments', 'navName' => 'My Payments', 'activeButton' => 'laravel'])

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <h1>My Payments</h1>
            <p>View and manage all your policy payments.</p>
        </div>
    </div>
    
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    
    <div class="card">
        <div class="card-header">
            <h5>Payment History</h5>
        </div>
        <div class="card-body">
            @if($payments->isEmpty())
                <p>You don't have any payment records yet.</p>
            @else
                <ul class="nav nav-tabs mb-4" id="paymentTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="all-tab" data-toggle="tab" data-target="#all" type="button" role="tab" aria-controls="all" aria-selected="true">All</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pending-tab" data-toggle="tab" data-target="#pending" type="button" role="tab" aria-controls="pending" aria-selected="false">Pending</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="paid-tab" data-toggle="tab" data-target="#paid" type="button" role="tab" aria-controls="paid" aria-selected="false">Paid</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="overdue-tab" data-toggle="tab" data-target="#overdue" type="button" role="tab" aria-controls="overdue" aria-selected="false">Overdue</button>
                    </li>
                </ul>
                
                <div class="tab-content" id="paymentTabsContent">
                    <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="all-tab">
                        @include('customer.payments._payment_table', ['paymentsToShow' => $payments])
                    </div>
                    <div class="tab-pane fade" id="pending" role="tabpanel" aria-labelledby="pending-tab">
                        @include('customer.payments._payment_table', ['paymentsToShow' => $payments->where('status', 'pending')])
                    </div>
                    <div class="tab-pane fade" id="paid" role="tabpanel" aria-labelledby="paid-tab">
                        @include('customer.payments._payment_table', ['paymentsToShow' => $payments->where('status', 'paid')])
                    </div>
                    <div class="tab-pane fade" id="overdue" role="tabpanel" aria-labelledby="overdue-tab">
                        @include('customer.payments._payment_table', ['paymentsToShow' => $payments->where('status', 'overdue')])
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection