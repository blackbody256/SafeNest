@extends('layouts.customerapp')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <h1>My Policy Applications</h1>
            <p>Track the status of your policy applications.</p>
        </div>
    </div>
    
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Application ID</th>
                            <th>Policy</th>
                            <th>Status</th>
                            <th>Submitted On</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($applications as $application)
                        <tr>
                            <td>{{ $application->Application_ID }}</td>
                            <td>{{ $application->policy->Title ?? 'Unknown Policy' }}</td>
                            <td>
                                @if($application->Status == 'pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @elseif($application->Status == 'accepted')
                                    <span class="badge bg-success">Accepted</span>
                                @elseif($application->Status == 'rejected')
                                    <span class="badge bg-danger">Rejected</span>
                                @else
                                    <span class="badge bg-secondary">{{ $application->Status }}</span>
                                @endif
                            </td>
                            <td>{{ $application->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <a href="{{ route('application.details', $application->Application_ID) }}" class="btn btn-sm btn-info">
                                    View Details
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">You haven't submitted any applications yet.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Application Details Modal -->
<div class="modal fade" id="applicationModal" tabindex="-1" aria-labelledby="applicationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="applicationModalLabel">Application Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title" id="app-policy">Loading...</h5>
                        <p class="card-text"><strong>Description:</strong> <span id="app-description"></span></p>
                        <p class="card-text"><strong>Premium:</strong> <span id="app-premium"></span></p>
                        <p class="card-text"><strong>Submitted On:</strong> <span id="app-created"></span></p>
                        <p class="card-text"><strong>Status:</strong> <span id="app-status"></span></p>
                        <p class="card-text"><strong>Notes:</strong> <span id="app-notes"></span></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@push('js')
<script>
$(document).ready(function() {
    $('.view-application').click(function() {
        const policy = $(this).data('policy');
        const description = $(this).data('description');
        const premium = $(this).data('premium');
        const status = $(this).data('status');
        const created = $(this).data('created');
        const notes = $(this).data('notes');
        
        $('#app-policy').text(policy);
        $('#app-description').text(description);
        $('#app-premium').text(premium);
        $('#app-created').text(created);
        
        let statusHtml = '';
        if (status === 'pending') {
            statusHtml = '<span class="badge bg-warning text-dark">Pending</span>';
        } else if (status === 'accepted') {
            statusHtml = '<span class="badge bg-success">Accepted</span>';
        } else if (status === 'rejected') {
            statusHtml = '<span class="badge bg-danger">Rejected</span>';
        } else {
            statusHtml = '<span class="badge bg-secondary">' + status + '</span>';
        }
        
        $('#app-status').html(statusHtml);
        $('#app-notes').text(notes);
    });
});
</script>
@endpush
@endsection