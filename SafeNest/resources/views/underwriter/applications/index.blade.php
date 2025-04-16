@extends('layouts.underwriterapp')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <h1>Policy Applications</h1>
            <p>Review and process customer policy applications.</p>
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
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Customer</th>
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
                            <td>{{ $application->user->name ?? 'Unknown User' }}</td>
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
                                <a href="{{ route('applications.show', $application->Application_ID) }}" class="btn btn-sm btn-info">Review</a>
                            </td>
                            </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">No applications found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
