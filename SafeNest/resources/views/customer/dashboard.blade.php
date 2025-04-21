@extends('layouts.customerapp', ['activePage' => 'Dashboard', 'title' => 'Sample', 'navName' => 'Customer Dashboard', 'activeButton' => 'laravel'])


@section('content')
<div class="container-fluid">
    <div class="row">

        {{-- Welcome Card --}}
        <div class="col-12 mb-4">
            <div class="card bg-dark text-white shadow-sm rounded">
                <div class="card-body text-center">
                    <h4 class="mb-0">👋 Welcome to your dashboard,{{ $user->name ?? 'Esteemed Client' }}!</h4>
                    @if ($duePayments && $duePayments->count())
                        @foreach ($duePayments as $payment)
                            <div class="alert alert-warning mt-3 d-flex align-items-center" role="alert" style="font-size: 16px;">
                                <i class="bi bi-bell me-2" style="font-size: 24px;"></i>
                                <div>
                                    <strong>Next Payment Due for {{ $payment->policy->Title ?? 'Policy' }}:</strong> 
                                    {{ \Carbon\Carbon::parse($payment->due_date)->format('F j, Y') }} 
                                    (UGX {{ number_format($payment->amount) }})
                                </div>
                            </div>
                        @endforeach
                    @endif

                </div>
            </div>
        </div>

        {{-- Applications Table --}}
        <div class="col-12">
            <div class="card shadow-sm rounded">
                <div class="card-header bg-light text-center" >
                    <h4 class="card-title mb-0">My Policy Applications</h4>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-hover ">
                        <thead class="text-primary">
                            <tr>
                                <th>Application ID</th>
                                <th>Policy Name</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($applications as $index => $application)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $application->policy->Title ?? 'N/A' }}</td>
                                    <td>
                                        @if(strtolower($application->Status) == 'pending')
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @elseif(strtolower($application->Status) == 'approved')
                                            <span class="badge bg-success">Approved</span>
                                        @else(strtolower($application->Status) == 'rejected')
                                            <span class="badge bg-danger">Rejected</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">No Applications Found</td>
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
    
@endpush
