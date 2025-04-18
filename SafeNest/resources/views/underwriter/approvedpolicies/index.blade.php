@extends('layouts.underwriterapp')

@section('content')
<div class="content">
    <div class="container-fluid">
        <h4>Approved Policies</h4>

        <div class="table-responsive">
            <table class="table">
                <thead class="text-primary">
                    <tr>
                        <th>Approved Policy ID</th>
                        <th>Client Name</th>
                        <th>Policy Title</th>
                        <th>Status</th>
                        <th>Expiry Date</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($approvedPolicies as $approved)
                    <tr>
                        <td>{{ $approved->Approved_Policy_ID }}</td> {{-- Fixed the capitalization --}}
                        <td>{{ $approved->user->name ?? 'N/A' }}</td>
                        <td>{{ $approved->policy->Title ?? 'N/A' }}</td>
                        <td>
                            @if(strtolower($approved->Status) == 'active')
                                <span class="text-success fw-bold">{{ $approved->Status }}</span>
                            @else
                                <span class="text-danger fw-bold">{{ $approved->Status }}</span>
                            @endif
                        </td>
                        <td>{{ $approved->expires_at ? $approved->expires_at->format('d/m/Y') : 'N/A' }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            @if($approvedPolicies->isEmpty())
                <p class="text-muted mt-3">No approved policies found.</p>
            @endif
        </div>
    </div>
</div>
@endsection
