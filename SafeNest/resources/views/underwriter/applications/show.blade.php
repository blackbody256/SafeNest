@extends('layouts.underwriterapp')

@section('content')
<div class="container">
    <div class = "row mb-4">
        <div class = "col-12">
            <h1>Application Review</h1>
            <p>Review the submitted documents and details for the application.</p>
        </div>
        <div>
            @if(session('error'))
                <div class = "alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="row">
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5>Application Details</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Application ID:</strong> {{ $application->Application_ID }}</p>
                        <p><strong>Status:</strong> 
                            @if($application->Status == 'pending')
                                <span class="badge bg-warning text-dark">Pending</span>
                            @elseif($application->Status == 'accepted')
                                <span class="badge bg-success">Accepted</span>
                            @elseif($application->Status == 'rejected')
                                <span class="badge bg-danger">Rejected</span>
                            @else
                                <span class="badge bg-secondary">{{ $application->Status }}</span>
                            @endif
                        </p>
                        <p><strong>Submitted On:</strong> {{ $application->created_at->format('d/m/Y H:i') }}</p>
                        <p><strong>Customer Notes:</strong> {{ $application->notes ?? 'No additional notes' }}</p>
                        
                        @if($application->Requirements_path)
                        <div class="mt-3">
                            <a href="{{ route('applications.download', $application->Application_ID) }}" class="btn btn-primary">
                                <i class="fas fa-download"></i> Download Documents
                            </a>
                        </div>
                        @else
                        <div class="alert alert-warning">
                            No documents were uploaded with this application.
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>


        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Customer Information</h5>
                </div>
                <div class="card-body">
                    <p><strong>Name:</strong> {{ $application->user->name ?? 'Unknown' }}</p>
                    <p><strong>Email:</strong> {{ $application->user->email ?? 'Unknown' }}</p>
                    <!-- Add more customer details as needed -->
                </div>
            </div>
            
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Policy Information</h5>
                </div>
                <div class="card-body">
                    <p><strong>Title:</strong> {{ $application->policy->Title ?? 'Unknown' }}</p>
                    <p><strong>Description:</strong> {{ $application->policy->Description ?? 'Unknown' }}</p>
                    <p><strong>Premium:</strong> {{ $application->policy->Premium ?? 'Unknown' }}</p>
                    <p><strong>Duration:</strong> {{ $application->policy->Duration ? Carbon\Carbon::parse($application->policy->Duration)->format('d/m/Y') : 'N/A' }}</p>
                </div>
            </div>
        </div>
    </div>
    
    @if($application->Status == 'pending')
    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Approve Application</h5>
                </div>
                <div class="card-body">
                    <p>Approving this application will create a new policy for the customer.</p>
                    <form action="{{ route('applications.approve', $application->Application_ID) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success">Approve Application</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Reject Application</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('applications.reject', $application->Application_ID) }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="rejection_reason">Reason for Rejection:</label>
                            <textarea class="form-control" id="rejection_reason" name="rejection_reason" rows="3" required></textarea>
                            @error('rejection_reason')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-danger">Reject Application</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif
    
    <div class="mt-3">
        <a href="{{ route('applications.index') }}" class="btn btn-secondary">Back to Applications</a>
    </div>
</div>
@endsection