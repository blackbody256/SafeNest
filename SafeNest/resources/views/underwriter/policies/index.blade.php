@extends('layouts.underwriterapp')

@section('content')
<div class="container">
    <h3>All Policies</h3>
    <a href="{{ route('policies.create') }}" class="btn btn-primary mb-3">Post New Policy</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Premium</th>
                <th>Duration</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($policies as $policy)
                <tr>
                    <td>{{ $policy->Title }}</td>
                    <td>{{ $policy->Description }}</td>
                    <td>{{ $policy->Premium }}</td>
                    <td>{{ $policy->Duration }}</td>
                    <td>
                        <a href="{{ route('policies.edit', $policy->Policy_ID) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('policies.destroy', $policy->Policy_ID) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
