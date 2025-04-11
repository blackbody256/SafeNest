@extends('layouts.underwriterapp')

@section('content')
<div class="container">
    <h3>Edit Policy</h3>
    <form method="POST" action="{{ route('policies.update', $policy->Policy_ID) }}">
        @csrf
        @method('PUT')
        @include('underwriter.policies.form', ['policy' => $policy])
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
