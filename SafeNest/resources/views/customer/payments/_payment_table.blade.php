@if($paymentsToShow->isEmpty())
    <p>No payments found in this category.</p>
@else
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Policy</th>
                    <th>Due Date</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Payment Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($paymentsToShow as $payment)
                    <tr>
                        <td>{{ $payment->policy->Title ?? 'Unknown Policy' }}</td>
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
@endif