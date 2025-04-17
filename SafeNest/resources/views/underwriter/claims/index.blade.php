@extends('layouts.underwriterapp')

@section('content')
<div class="container">
    <h2>Manage Claims</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Claim ID</th>
                <th>Client</th>
                <th>Policy</th>
                <th>Reason</th>
                <th>Status</th>
                <th>Attachment</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($claims as $claim)
            <tr>
                <td>{{ $claim->Claim_ID }}</td>
                <td>{{ $claim->user->name ?? 'N/A' }}</td>
                <td>{{ $claim->policy->Title ?? 'N/A' }}</td>
                <td>{{ $claim->Description ?? 'N/A' }}</td>
                <td>{{ $claim->Status ?? 'N/A' }}</td>
                <td>
                    @if($claim->attachment)
                        <a href="{{ asset('storage/' . $claim->attachment) }}" target="_blank">View Attachment</a>
                    @else
                        No file
                    @endif
                </td>
                <td>
                    @if($claim->Status === 'Pending')
                        <form action="{{ route('claims.updateStatus', $claim->Claim_ID) }}" method="POST" class="d-flex">
                            @csrf
                            <select name="status" class="form-control mr-2">
                                <option value="Pending" {{ $claim->Status === 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="Approved">Approve</option>
                                <option value="Rejected">Reject</option>
                            </select>
                            <button type="submit" class="btn btn-primary btn-sm">Update</button>
                        </form>
                    @else
                        <span class="text-muted">Action completed</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
