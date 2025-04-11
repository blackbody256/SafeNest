@extends('layouts.underwriterapp')

@section('content')
<div class="container">
    <h3>Post New Policy</h3>
    <form method="POST" action="{{ route('policies.store') }}">
        @csrf
        @include('underwriter.policies.form')
        <button type="submit" class="btn btn-success">Submit</button>
    </form>
</div>
@endsection
