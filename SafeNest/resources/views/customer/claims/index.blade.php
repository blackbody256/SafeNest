@extends('layouts.customerapp')




@section('content')
<div class="container">
    <h1> Fill Claim Form</h1>
<a href="{{ route('customer.claims.create') }}" class="btn btn-success mb-3">Submit New Claim</a>


    <h2>My Submitted Claims</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Claim ID</th>
                <th>Policy</th>
                <th>Reason</th>
                <th>Status</th>
                <th>Submitted On</th>
            </tr>
        </thead>
        <tbody>
            @foreach($claims as $claim)
                <tr>
                    <td>{{ $claim->Claim_ID }}</td>
                    <td>
                         @if($claim->policy)
                         {{ $claim->policy->Policy_ID }} 
                          @else
                              N/A
                         @endif
                    </td>
                    <td>{{ $claim->Description }}</td>
                    <td>{{ $claim->Status }}</td>

                    
                    <td>{{ $claim->created_at->format('d M Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
