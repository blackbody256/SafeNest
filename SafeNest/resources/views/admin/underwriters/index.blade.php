@extends('layouts.adminapp', [
    'activePage' => 'underwriters',
    'title' => 'Underwriters',
    'navName' => 'Underwriters',
    'activeButton' => 'laravel'
])

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Underwriter Management</h1>
        <a href="{{ route('admin.underwriters.create') }}" class="btn btn-success btn-sm">
            <i class="bi bi-plus-circle"></i> Add Underwriter
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body p-0">
            <table class="table table-striped table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Commission Rate</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($underwriters as $underwriter)
                        <tr>
                            <td>{{ $underwriter->user->name }}</td>
                            <td>{{ $underwriter->user->email }}</td>
                            <td>{{ $underwriter->commission_rate }}%</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <!-- Edit Button -->
                                    <a href="{{ route('admin.underwriters.edit', $underwriter) }}"
                                       class="btn btn-primary btn-sm me-2">
                                        Edit
                                    </a>

                                    <!-- Demote Button -->
                                    <form action="{{ route('admin.underwriters.destroy', $underwriter) }}"
                                          method="POST" onsubmit="return confirm('Are you sure you want to demote this underwriter?')"
                                          class="me-2">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-warning btn-sm">
                                            Demote
                                        </button>
                                    </form>

                                    <!-- Delete Button -->
                                    <form action="{{ route('admin.underwriters.destroy', $underwriter) }}"
                                          method="POST" onsubmit="return confirm('Are you sure you want to delete this underwriter?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="card-footer">
            {{ $underwriters->links() }}
        </div>
    </div>
</div>

<style>
    .btn-sm {
        min-width: 80px;
        padding: 5px 10px;
        font-size: 14px;
        border-radius: 5px;
        margin-left: 5px;
        margin-right: 5px;
        color: #fff;
        
    }
    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        
    }
    .btn-primary:hover {
        
        border-color: #004085;
    }
    .btn-warning {
        background-color: #ffc107;
        border-color: #ffc107;
        
    }
    .btn-warning:hover {
        
        border-color: #d39e00;
    }
    .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
        
    }
    .btn-danger:hover {
        
        border-color: #bd2130;
    }

    

    .btn-success {
        background-color: #28a745;
        border-color: #28a745;
        color: #fff;
        padding: 8px 16px;
        font-size: 14px;
        border-radius: 5px;


    }

    .btn-success:hover {
        
        border-color: #1e7e34;
    }


</style>
@endsection
