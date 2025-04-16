@extends('layouts.customerapp')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <h1>Apply for Policy: {{ $policy->Title }}</h1>
            <p>Please fill out the form below to submit your application.</p>
        </div>
    </div>
    
    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif
    
    <div class="card">
        <div class="card-header">
            <h5>Policy Details</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Title:</strong> {{ $policy->Title }}</p>
                    <p><strong>Description:</strong> {{ $policy->Description }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Premium:</strong> {{ $policy->Premium }}</p>
                    <p><strong>Duration:</strong> {{ \Carbon\Carbon::parse($policy->Duration)->format('Y/m/d') ?? 'N/A' }}</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card mt-4">
        <div class="card-header">
            <h5>Application Form</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('policy.application.submit', $policy->Policy_ID) }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="form-group mb-3">
                    <label for="documents">Required Documents</label>
                    <div class="alert alert-info">
                        <p>Please upload the following documents:</p>
                        <ul>
                            <li>Valid ID (Passport/Driver's License/National ID)</li>
                            <li>Proof of address (utility bill, bank statement)</li>
                            <li>Any other relevant documents</li>
                        </ul>
                    </div>
                    <input type="file" class="form-control" id="documents" name="documents[]" multiple required>
                    <small class="form-text text-muted">You can select multiple files. Accepted formats: PDF, JPG, PNG, DOC, DOCX. Maximum file size: 10MB per file.</small>
                    @error('documents.*')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group mb-3">
                    <label for="notes">Additional Notes</label>
                    <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Any additional information you'd like us to know..."></textarea>
                    @error('notes')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Submit Application</button>
                    <a href="{{ route('policy.catalogue') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection