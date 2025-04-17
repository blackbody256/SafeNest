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
                        <th>Client (user_id)</th>
                        <th>Policy ID</th>
                        <th>Status</th>
                        <th>Expiry Date</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($approvedPolicies as $approved)
          <tr>
        <td>{{ $approved->Approved_policy_ID }}</td> {{-- Approved Policy ID --}}
        <td>{{ $approved->user->name ?? 'N/A' }}</td> {{-- User name --}}
        <td>{{ $approved->policy->Title ?? 'N/A' }}</td> {{-- Policy title --}}
        <td>{{ $approved->Status }}</td> {{-- Status (active/expired) --}}
        <td>{{ $approved->Expiry_Date }}</td> {{-- Expiry Date --}}
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
