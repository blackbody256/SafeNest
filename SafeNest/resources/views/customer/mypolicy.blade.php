@extends('layouts.customerapp', ['activePage' => 'My policies', 'title' => 'My policies', 'navName' => 'My Policies', 'activeButton' => 'laravel'])

@section('content')
<div class="container">
    <h1>My Policies</h1>
    
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
    
    @if($approvedPolicies->isEmpty())
        <p>You don't have any approved policies yet.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Policy Name</th>
                    <th>Status</th>
                    <th>Expires At</th>
                    <th>Payment Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @foreach($approvedPolicies as $approvedPolicy)
                @php
                    // Get payment summary for this policy
                    $paymentSummary = App\Http\Controllers\PaymentController::getPaymentSummary($approvedPolicy->Approved_Policy_ID);
                @endphp
                <tr>
                    <td>{{ $approvedPolicy->policy->Title ?? 'Unknown Policy' }}</td>
                    <td>{{ $approvedPolicy->Status }}</td>
                    <td>{{ $approvedPolicy->expires_at ? $approvedPolicy->expires_at->format('d/m/Y') : 'N/A' }}</td>
                    <td>
                        <div>
                            @if($paymentSummary['overdueCount'] > 0)
                                <span class="badge bg-danger">{{ $paymentSummary['overdueCount'] }} Overdue</span>
                            @elseif($paymentSummary['pending'] > 0)
                                <span class="badge bg-warning text-dark">Payments Pending</span>
                            @else
                                <span class="badge bg-success">Fully Paid</span>
                            @endif
                        </div>
                        <small>
                            Paid: ${{ number_format($paymentSummary['paid'], 2) }} | 
                            Remaining: ${{ number_format($paymentSummary['pending'], 2) }}
                        </small>
                    </td>
                    <td>
                        <button type="button" class="btn btn-sm btn-info view-details" 
                                data-toggle="modal" data-target="#policyModal" 
                                data-id="{{ $approvedPolicy->Policy_ID }}">
                            View Details
                        </button>
                        
                        @if($paymentSummary['nextPayment'])
                            <a href="{{ route('customer.payment.view', $approvedPolicy->Approved_Policy_ID) }}" 
                               class="btn btn-sm btn-primary">
                                View Payments
                            </a>
                            
                            @if($paymentSummary['nextPayment']->status != 'paid')
                                <form method="POST" action="{{ route('customer.payment.make', $paymentSummary['nextPayment']->id) }}" 
                                      style="display: inline-block;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success">
                                        Pay Next Installment
                                    </button>
                                </form>
                            @endif
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
</div>

<!-- Policy Details Modal -->
<div class="modal fade" id="policyModal" tabindex="-1" role="dialog" aria-labelledby="policyModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="policyModalLabel">Policy Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title" id="policy-title">Loading...</h5>
                        <p class="card-text"><strong>Description:</strong> <span id="policy-description"></span></p>
                        <p class="card-text"><strong>Premium:</strong> <span id="policy-premium"></span></p>
                        <p class="card-text"><strong>Created At:</strong> <span id="policy-created-at"></span></p>
                        <p class="card-text"><strong>Expires At:</strong> <span id="policy-expires-at"></span></p>
                        <p class="card-text"><strong>Status:</strong> <span id="policy-status"></span></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
$(document).ready(function() {
    $('.view-details').click(function() {
        const policyId = $(this).data('id');
        
        // Reset modal content
        $('#policy-title').text('Loading...');
        $('#policy-description').text('');
        $('#policy-premium').text('');
        $('#policy-created-at').text('');
        $('#policy-expires-at').text('');
        $('#policy-status').text('');
        
        // Fetch policy details
        $.ajax({
            url: `/policies/${policyId}`,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                $('#policy-title').text(data.policy.Title);
                $('#policy-description').text(data.policy.Description);
                $('#policy-premium').text(data.policy.Premium);
                $('#policy-created-at').text(new Date(data.policy.created_at).toLocaleDateString());
                
                if (data.approvedPolicy && data.approvedPolicy.expires_at) {
                    $('#policy-expires-at').text(new Date(data.approvedPolicy.expires_at).toLocaleDateString());
                } else {
                    $('#policy-expires-at').text('N/A');
                }
                
                if (data.approvedPolicy) {
                    $('#policy-status').text(data.approvedPolicy.Status);
                } else {
                    $('#policy-status').text('N/A');
                }
            },
            error: function() {
                $('#policy-title').text('Error loading policy details');
            }
        });
    });
});
</script>
@endpush