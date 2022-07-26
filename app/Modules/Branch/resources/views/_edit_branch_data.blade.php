<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label>Branch Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="name" value="{{ $branch->name }}" required>
        </div>
    </div>
</div>
<div class="row mt-4">
    <div class="col-md-12">
        <div class="form-group">
            <label>Phone <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="phone" value="{{ $branch->contact_phone }}" required>
        </div>
    </div>
</div>
<div class="row mt-4">
    <div class="col-md-12">
        <div class="form-group">
            <label>Address <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="address" value="{{ $branch->address }}" required>
        </div>
    </div>
</div>
<div class="row mt-4">
    <div class="col-md-12">
        <div class="form-group">
            <label>Note </label>
            <textarea name="note" class="form-control" rows="4">{{ $branch->note }}</textarea>
        </div>
    </div>
</div>
