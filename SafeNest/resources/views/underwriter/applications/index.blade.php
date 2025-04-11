@extends('layouts.underwriterapp')

@section('content')
<div class="container">
    <h2 class="mb-4">Approve or Reject Policies</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Application ID</th>
                <th>Policy Title</th>
                <th>Applicant (User ID)</th>
                <th>Status</th>
                <th>Date Applied</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($applications as $application)
                <tr>
                    <td>{{ $application->Application_ID }}</td>
                    <td>{{ $application->policy->Title ?? 'N/A' }}</td>
                    <td>{{ $application->User_ID }}</td>
                    <td>
                        @if($application->Status == 'Approved')
                            <span class="badge bg-success">Approved</span>
                        @elseif($application->Status == 'Rejected')
                            <span class="badge bg-danger">Rejected</span>
                        @else
                            <span class="badge bg-secondary">Pending</span>
                        @endif
                    </td>
                    <td>{{ $application->Date_Applied }}</td>
                    <td>
                        @if($application->Status == 'Pending')
                            <form action="{{ route('applications.approve', $application->Application_ID) }}" method="POST" style="display:inline-block;">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">Approve</button>
                            </form>

                            <form action="{{ route('applications.reject', $application->Application_ID) }}" method="POST" style="display:inline-block;">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                            </form>
                        @else
                            <em>No actions available</em>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
