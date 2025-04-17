@extends('layouts.customerapp')

@section('content')
<div class="container">
    <h2>Make a Claim</h2>
    <form action="{{ route('customer.claims.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="policy_id">Select Policy</label>
            <select name="policy_id" class="form-control" required>
               <option value="">-- Select a Policy --</option>
                @foreach($policies as $policy)
                  <option value="{{ $policy->Policy_ID }}">{{ $policy->Title }}</option>
                 @endforeach
          </select>
 

        </div>

        <div class="form-group mt-3">
            <label for="reason">Reason for Claim</label>
            <textarea name="description" class="form-control" rows="4" required></textarea>
        </div>

        <label for="attachment">Attach File (optional)</label>
        <input type="file" name="attachment" id="attachment" class="form-control">

        <button type="submit" class="btn btn-primary mt-3">Submit Claim</button>
    </form>
</div>
@endsection
