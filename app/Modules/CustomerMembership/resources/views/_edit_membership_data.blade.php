<div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label>Membership Title <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="title" value="{{$membership->title}}" required>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="form-group">
                <label>Discount Type <span class="text-danger">*</span></label>
                <select name="discount_type" class="form-control default-select" required>
                    <option value="">Select Discount Type</option>
                    <option value="0" {{$membership->discount_type==0?'selected':''}}>Fixed</option>
                    <option value="1" {{$membership->discount_type==1?'selected':''}}>percentage</option>
                </select>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="form-group">
                <label>Discount Value <span class="text-danger">*</span></label>
                <input type="number" step="any" class="form-control" name="discount_value" value="{{$membership->discount_value}}" required>

            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="form-group">
                <label>Icon </label>
                <input type="file" class="form-control dropify" name="icon"  data-height="120" data-default-file="{{ asset($membership->default_icon) }}">

            </div>
        </div>
    </div>
