@extends('layouts.customerapp', ['activePage' => 'My Applications', 'title' => 'Application Details', 'navName' => 'Application Details', 'activeButton' => 'laravel'])

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <h1>Application Details</h1>
            <a href="{{ route('my.applications') }}" class="btn btn-sm btn-outline-primary">
                <i class="nc-icon nc-stre-left"></i> Back to Applications
            </a>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Policy Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Policy Name:</strong> {{ $application->policy->Title }}</p>
                            <p><strong>Description:</strong> {{ $application->policy->Description }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Premium:</strong> {{ $application->policy->Premium }}</p>
                            <p><strong>Duration:</strong> {{ \Carbon\Carbon::parse($application->policy->Duration)->format('Y/m/d') ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-12 mt-4">
            <div class="card">
                <div class="card-header">
                    <h5>Application Status</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Application ID:</strong> {{ $application->Application_ID }}</p>
                            <p><strong>Date Applied:</strong> {{ \Carbon\Carbon::parse($application->Date_Applied)->format('d/m/Y') }}</p>
                        </div>
                        <div class="col-md-6">
                            <p>
                                <strong>Status:</strong> 
                                @if($application->Status == 'Pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @elseif($application->Status == 'Approved')
                                    <span class="badge bg-success">Approved</span>
                                @elseif($application->Status == 'Rejected')
                                    <span class="badge bg-danger">Rejected</span>
                                @else
                                    <span class="badge bg-secondary">{{ $application->Status }}</span>
                                @endif
                            </p>
                            <p><strong>Last Updated:</strong> {{ $application->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                    
                    @if($application->notes)
                    <div class="mt-3">
                        <h6>Additional Notes:</h6>
                        <div class="p-3 bg-light rounded">
                            {{ $application->notes }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        
        @if(isset($application->documents) && count($application->documents) > 0)
        <div class="col-md-12 mt-4">
            <div class="card">
                <div class="card-header">
                    <h5>Uploaded Documents</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Filename</th>
                                    <th>Type</th>
                                    <th>Uploaded On</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($application->documents as $document)
                                <tr>
                                    <td>{{ $document->filename }}</td>
                                    <td>{{ $document->file_type }}</td>
                                    <td>{{ $document->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection