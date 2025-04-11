<div class="form-group">
    <label>Title</label>
    <input type="text" name="Title" value="{{ old('Title', $policy->Title ?? '') }}" class="form-control">
</div>

<div class="form-group">
    <label>Description</label>
    <input type="text" name="Description" value="{{ old('Description', $policy->Description ?? '') }}" class="form-control">
</div>

<div class="form-group">
    <label>Premium</label>
    <input type="text" name="Premium" value="{{ old('Premium', $policy->Premium ?? '') }}" class="form-control">
</div>

<div class="form-group">
    <label>Duration</label>
    <input type="date" name="Duration" value="{{ old('Duration', $policy->Duration ?? '') }}" class="form-control">
</div>
