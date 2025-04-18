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
                                <button type="button" class="btn btn-sm btn-success open-payment-modal" 
                                        data-payment-id="{{ $paymentSummary['nextPayment']->id }}"
                                        data-amount="{{ $paymentSummary['nextPayment']->amount }}">
                                    Pay Next Installment
                                </button>
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

<!-- Payment Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentModalLabel">Payment Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="paymentForm">
                    @csrf
                    <input type="hidden" id="payment_id" name="payment_id">
                    
                    <div class="alert alert-info">
                        Amount to be paid: <strong>$<span id="payment-amount">0.00</span></strong>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="payment_method">Payment Method</label>
                        <select class="form-control" id="payment_method" name="payment_method" required>
                            <option value="">Select Payment Method</option>
                            <option value="credit_card">Credit Card</option>
                            <option value="debit_card">Debit Card</option>
                        </select>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="card_holder">Card Holder Name</label>
                        <input type="text" class="form-control" id="card_holder" name="card_holder" required>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="card_number">Card Number</label>
                        <input type="text" class="form-control" id="card_number" name="card_number" 
                               placeholder="XXXX XXXX XXXX XXXX" maxlength="19" required>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="expiry_date">Expiry Date (MM/YY)</label>
                                <input type="text" class="form-control" id="expiry_date" name="expiry_date" 
                                       placeholder="MM/YY" maxlength="5" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="cvv">CVV</label>
                                <input type="text" class="form-control" id="cvv" name="cvv" 
                                       placeholder="XXX" maxlength="3" required>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="confirmPayment">Confirm Payment</button>
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

    // Payment Modal Handling
    $('.open-payment-modal').click(function() {
        const paymentId = $(this).data('payment-id');
        const amount = $(this).data('amount');
        
        $('#payment_id').val(paymentId);
        $('#payment-amount').text(parseFloat(amount).toFixed(2));
        $('#paymentModal').modal('show');
    });
    
    // Format card number with spaces
    $('#card_number').on('input', function() {
        let value = $(this).val().replace(/\s+/g, '').replace(/[^0-9]/gi, '');
        let formattedValue = '';
        
        for (let i = 0; i < value.length; i++) {
            if (i > 0 && i % 4 === 0) {
                formattedValue += ' ';
            }
            formattedValue += value[i];
        }
        
        $(this).val(formattedValue);
    });
    
    // Format expiry date
    $('#expiry_date').on('input', function() {
        let value = $(this).val().replace(/\D/g, '');
        
        if (value.length > 2) {
            value = value.substring(0, 2) + '/' + value.substring(2, 4);
        }
        
        $(this).val(value);
    });
    
    // CVV should only contain numbers
    $('#cvv').on('input', function() {
        $(this).val($(this).val().replace(/\D/g, ''));
    });
    
    // Handle payment confirmation
    $('#confirmPayment').click(function() {
        // Validate form
        const form = document.getElementById('paymentForm');
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }
        
        // Create a form to submit
        const submissionForm = $('<form></form>');
        submissionForm.attr('method', 'POST');
        
        // Correctly set the action URL with the payment ID from the form
        const paymentId = $('#payment_id').val();
        submissionForm.attr('action', '{{ url('/customer/payments') }}/' + paymentId + '/pay');
        
        // Add CSRF token
        submissionForm.append($('<input>').attr({
            type: 'hidden',
            name: '_token',
            value: '{{ csrf_token() }}'
        }));
        
        // Add payment details
        const paymentData = {
            payment_method: $('#payment_method').val(),
            card_holder: $('#card_holder').val(),
            card_number: $('#card_number').val().replace(/\s/g, ''),
            expiry_date: $('#expiry_date').val(),
            cvv: $('#cvv').val()
        };
        
        // Add each field as hidden input
        $.each(paymentData, function(key, value) {
            submissionForm.append($('<input>').attr({
                type: 'hidden',
                name: key,
                value: value
            }));
        });
        
        // Append to body and submit
        submissionForm.appendTo('body').submit();
    });
});
</script>
@endpush