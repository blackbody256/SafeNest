@extends('layouts.adminapp', [
    'activePage' => 'underwriters',
    'title' => 'Edit Underwriter',
    'navName' => 'Underwriters',
    'activeButton' => 'laravel'
])

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Update Commission Rate</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.underwriters.update', $underwriter) }}">
                            @csrf @method('PUT')
                            
                            <div class="form-group">
                                <label>Current Commission Rate</label>
                                <input type="number" step="0.01" min="0" max="100" 
                                       name="commission_rate" class="form-control"
                                       value="{{ old('commission_rate', $underwriter->commission_rate) }}" required>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Rate
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection