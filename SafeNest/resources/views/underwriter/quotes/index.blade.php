@extends('layouts.underwriterapp')

@section('content')
<div class="container">

    {{-- All Quotes --}}
    <div class="card mb-5">
        <div class="card-header">
            <h4>All Quotes</h4>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Quote ID</th>
                        <th>Client Name</th>
                        <th>Policy Title</th>
                        <th>Description</th>
                        <th>Amount</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($quotes as $quote)
                    <tr>
                        <td>{{ $quote->Quotes_ID }}</td>
                        <td>{{ $quote->user->name ?? 'N/A' }}</td>
                        <td>{{ $quote->policy->Title ?? 'N/A' }}</td>
                        <td>{{ $quote->Description }}</td>
                        <td>UGX {{ number_format($quote->Amount) }}</td>
                        <td class="d-flex gap-2">
                            <!-- View Button -->
                            <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#viewModal{{ $quote->Quotes_ID }}">
                                View
                            </button>

                            <!-- Delete Button triggers modal -->
                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $quote->Quotes_ID }}">
                                Delete
                            </button>
                        </td>
                    </tr>

                    {{-- View Modal --}}
                    <div class="modal fade" id="viewModal{{ $quote->Quotes_ID }}" tabindex="-1" aria-labelledby="viewModalLabel{{ $quote->Quotes_ID }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Quote Details</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <p><strong>Client:</strong> {{ $quote->user->name ?? 'N/A' }}</p>
                                    <p><strong>Policy:</strong> {{ $quote->policy->Title ?? 'N/A' }}</p>
                                    <p><strong>Description:</strong> {{ $quote->Description }}</p>
                                    <p><strong>Amount:</strong> UGX {{ number_format($quote->Amount) }}</p>
                                    <p><strong>Duration:</strong> {{ \Carbon\Carbon::parse($quote->policy->Duration)->format('Y/m/d') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Delete Modal --}}
                    <div class="modal fade" id="deleteModal{{ $quote->Quotes_ID }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $quote->Quotes_ID }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <form method="POST" action="{{ route('underwriter.quotes.index.delete', $quote->Quotes_ID) }}">
                                @csrf
                                @method('DELETE')
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Confirm Deletion</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure you want to delete this quote?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Expired Quotes --}}
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>Expired Quotes</h4>
            <form action="{{ route('underwriter.quotes.index.deleteExpired') }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm"
                        onclick="return confirm('Are you sure you want to delete all expired quotes?');">
                    Delete All Expired
                </button>
            </form>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Quote ID</th>
                        <th>Client Name</th>
                        <th>Policy Title</th>
                        <th>Description</th>
                        <th>Expired On</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($expiredQuotes as $quote)
                    <tr>
                        <td>{{ $quote->Quotes_ID }}</td>
                        <td>{{ $quote->user->name ?? 'N/A' }}</td>
                        <td>{{ $quote->policy->Title ?? 'N/A' }}</td>
                        <td>{{ $quote->Description }}</td>
                        <td>{{ \Carbon\Carbon::parse($quote->policy->Duration)->format('Y/m/d') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">No expired quotes.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
