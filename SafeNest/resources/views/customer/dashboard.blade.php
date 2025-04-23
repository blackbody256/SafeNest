@extends('layouts.customerapp', [
    'activePage' => 'Dashboard', 
    'title' => 'Sample', 
    'navName' => 'Customer Dashboard', 
    'activeButton' => 'laravel'
])

@section('content')
<div class="container-fluid">
    <div class="row">

        {{-- Welcome Card --}}
        <div class="col-12 mb-4">
            <div class="card bg-dark text-white shadow-sm rounded">
                <div class="card-body text-center">
                    <h4 class="mb-0">👋 Welcome to your dashboard, {{ $user->name ?? 'Esteemed Client' }}!</h4>

                    <!-- Show Overdue Payments -->
                    @if ($overduePayments && $overduePayments->count())
                        @foreach ($overduePayments as $payment)
                            <div class="alert alert-danger mt-3 d-flex align-items-center" role="alert" style="font-size: 16px;">
                                <i class="bi bi-exclamation-triangle-fill me-2" style="font-size: 24px;"></i>
                                <div>
                                    <strong>Overdue Payment for {{ $payment->approvedPolicy->policy->Title ?? 'Policy' }}:</strong> 
                                    {{ \Carbon\Carbon::parse($payment->due_date)->format('F j, Y') }} 
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="alert alert-success text-center mt-3">
                            🎉 No overdue payments at the moment. You're all caught up!
                        </div>
                    @endif

                </div>
            </div>
        </div>

        {{-- Payments Table --}}
        <div class="col-12">
            <div class="card shadow-sm rounded">
                <div class="card-header bg-light text-center">
                    <h4 class="card-title mb-0">My Policy Payments</h4>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-hover">
                        <thead class="text-primary">
                            <tr>
                                <th>Application ID</th>
                                <th>Policy Name</th>
                                <th>Status</th>
                                <th>Next Due-Date</th>
                                <th>Premium</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($payments as $index => $payment)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $payment->approvedPolicy->policy->Title ?? 'N/A' }}</td>
                                    <td>
                                        @if(strtolower($payment->status) == 'pending')
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @elseif(strtolower($payment->status) == 'paid')
                                            <span class="badge bg-success">Paid</span>
                                        @elseif(strtolower($payment->status) == 'overdue')
                                            <span class="badge bg-danger">Overdue</span>
                                        @else
                                            <span class="badge bg-secondary">Unknown</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $payment->due_date ? \Carbon\Carbon::parse($payment->due_date)->format('F j, Y') : 'N/A' }}
                                    </td>
                                    <td>
                                        UGX {{ number_format($payment->amount) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No Payments Found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@push('js')
{{-- You can add page-specific JS here if needed --}}
@endpush
