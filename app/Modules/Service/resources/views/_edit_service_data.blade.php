
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="form-group">
                <label>Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="name" value="{{$services->name}}" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Price <span class="text-danger">*</span></label>
                <input type="number" class="form-control" name="price" value="{{$services->price}}" required>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="form-group">
                <label>Discount Type</label>
                <select name="discount_type" class="default-select form-control wide" required>
                    <option value="">-SELECT-</option>
                    <option value="0" {{$services->discount_type==0?'selected':''}}>Fixed</option>
                    <option value="1" {{$services->discount_type==1?'selected':''}}>Percentage</option>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Discount Value <span class="text-danger">*</span></label>
                <input type="number" class="form-control"  name="discount_value" value="{{ $services->discount_value }}" required>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-12">
            <div class="form-group">
                <label>Description</label>
                <textarea class="form-control" name="description"  cols="30" rows="10">{{$services->description}}</textarea>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-12">
            <div class="form-group">
                <label>Image</label>
                <input type="file" class="dropify form-control" name="image" data-height="100" data-default-file="{{ asset($services->default_image) }}" accept="image/*">
            </div>
        </div>
    </div>
