@extends('layouts.underwriterapp')

@section('content')
<div class="container">
    <h3>{{ $navName }}</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Quote ID</th>
                <th>Client Name</th>
                <th>Policy Title</th>
                <th>Description</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($quotes as $quote)
                <tr>
                    <td>{{ $quote->Quotes_ID }}</td>
                    <td>{{ $quote->user->name ?? 'N/A' }}</td>
                    <td>{{ $quote->policy->Title ?? 'N/A' }}</td>
                    <td>{{ $quote->Description }}</td>
                    <td>UGX {{ number_format($quote->Amount) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
