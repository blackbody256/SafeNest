@extends('layouts.customerapp', ['activePage' => 'Dashboard', 'title' => 'Sample', 'navName' => 'Customer Dashboard', 'activeButton' => 'laravel'])


@section('content')
<div class="container-fluid">
    <div class="row">

        {{-- Welcome Card --}}
        <div class="col-12 mb-4">
            <div class="card bg-dark text-white shadow-sm rounded">
                <div class="card-body text-center">
                    <h4 class="mb-0">👋 Welcome Esteemed Client</h4>
                    <p class="mb-0 mt-2">Here you can view your policy applications easily.</p>
                </div>
            </div>
        </div>

        {{-- Applications Table --}}
        <div class="col-12">
            <div class="card shadow-sm rounded">
                <div class="card-header bg-light text-center" >
                    <h4 class="card-title mb-0">My Policy Applications</h4>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-hover ">
                        <thead class="text-primary">
                            <tr>
                                <th>Application ID</th>
                                <th>Policy Name</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($applications as $index => $application)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $application->policy->Title ?? 'N/A' }}</td>
                                    <td>
                                        @if($application->Status == 'Pending')
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @elseif($application->Status == 'Approved')
                                            <span class="badge bg-success">Approved</span>
                                        @elseif($application->Status == 'Rejected')
                                            <span class="badge bg-danger">Rejected</span>
                                        @else
                                            <span class="badge bg-secondary">Unknown</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">No Applications Found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@push('js')
    
@endpush
