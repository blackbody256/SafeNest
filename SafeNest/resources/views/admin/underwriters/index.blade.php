@extends('layouts.adminapp', [
    'activePage' => 'underwriters',
    'title' => 'Underwriters',
    'navName' => 'Underwriters',
    'activeButton' => 'laravel'
])

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Underwriters</h4>
                    </div>
                    <div class="card-body">
                        <a href="{{ route('admin.underwriters.create') }}" class="btn btn-primary mb-3">
                            <i class="fas fa-plus"></i> Add Underwriter
                        </a>

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Commission Rate</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($underwriters as $underwriter)
                                    <tr>
                                        <td>{{ $underwriter->user->name }}</td>
                                        <td>{{ $underwriter->user->email }}</td>
                                        <td>{{ $underwriter->commission_rate }}%</td>
                                        <td>
                                            <a href="{{ route('admin.underwriters.edit', $underwriter) }}" 
                                               class="btn btn-sm btn-info">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <form action="{{ route('admin.underwriters.destroy', $underwriter) }}" 
                                                  method="POST" class="d-inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Remove underwriter status?')">
                                                    <i class="fas fa-trash"></i> Remove
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            {{ $underwriters->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection