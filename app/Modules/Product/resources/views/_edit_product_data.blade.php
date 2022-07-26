<div class="row mt-4">
        <div class="col-md-6">
            <div class="form-group">
                <label>Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="name" value="{{ $product->name}}" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Price <span class="text-danger">*</span></label>
                <input type="number" class="form-control" name="price" value="{{ $product->price }}" required>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-12">
            <div class="form-group">
                <label>Note </label>
                <textarea name="note" class="form-control" id="" cols="30" rows="10">{{ $product->note }}</textarea>
            </div>
        </div>
    </div>

<div class="row mt-4">
    <div class="col-12">
        <div class="form-group">
            <label>Image</label>
            <input type="file" class="dropify form-control" name="image"  accept="image/*" data-height="120" data-default-file="{{ asset($product->default_image) }}">
        </div>
    </div>
</div>

