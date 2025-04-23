@extends('layouts.customerapp', ['activePage' => 'My payments', 'title' => 'Policy Payments', 'navName' => 'Policy Payments', 'activeButton' => 'laravel'])

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-6">
            <h1>Policy Payments</h1>
            <p>View and manage payments for your policy.</p>
        </div>
        <div class="col-md-6 text-right">
            <a href="{{ route('mypolicies') }}" class="btn btn-secondary">Back to My Policies</a>
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
    
    <div class="card mb-4">
        <div class="card-header">
            <h5>Policy Information</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Policy Name:</strong> {{ $approvedPolicy->policy->Title ?? 'Unknown' }}</p>
                    <p><strong>Status:</strong> {{ $approvedPolicy->Status }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Premium:</strong> UGx{{ number_format($approvedPolicy->policy->Premium ?? 0, 2) }}</p>
                    <p><strong>Expires At:</strong> {{ $approvedPolicy->expires_at ? $approvedPolicy->expires_at->format('d/m/Y') : 'N/A' }}</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card">
        <div class="card-header">
            <h5>Payment Schedule</h5>
        </div>
        <div class="card-body">
            @if($payments->isEmpty())
                <p>No payment records found for this policy.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Payment #</th>
                                <th>Due Date</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Payment Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($payments as $index => $payment)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $payment->due_date->format('d/m/Y') }}</td>
                                    <td>${{ number_format($payment->amount, 2) }}</td>
                                    <td>
                                        @if($payment->status == 'paid')
                                            <span class="badge bg-success">Paid</span>
                                        @elseif($payment->status == 'overdue')
                                            <span class="badge bg-danger">Overdue</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @endif
                                    </td>
                                    <td>{{ $payment->payment_date ? $payment->payment_date->format('d/m/Y') : 'Not paid yet' }}</td>
                                    <td>
                                        @if($payment->status != 'paid')
                                            <form method="POST" action="{{ route('customer.payment.make', $payment->id) }}">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success">
                                                    Make Payment
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-muted">Completed</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="payment-summary mt-4">
                    <h6>Payment Summary</h6>
                    <div class="row">
                        <div class="col-md-4">
                            <p><strong>Total Amount:</strong> UGx{{ number_format($payments->sum('amount'), 2) }}</p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>Paid Amount:</strong> UGx{{ number_format($payments->where('status', 'paid')->sum('amount'), 2) }}</p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>Remaining Amount:</strong> UGx{{ number_format($payments->whereIn('status', ['pending', 'overdue'])->sum('amount'), 2) }}</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection