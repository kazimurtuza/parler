<div class="row mt-4">
    @if(isAdmin())
        <div class="col-md-6">
            <div class="form-group">
                <label>Branch <span class="text-danger">*</span></label>
                <select name="branch_id" class="default-select form-control wide" id="">
                    <option value="">Select Branch</option>
                    @foreach($branches as $branch)
                        <option value="{{$branch->id}}" {{$branch_service->branch_id==$branch->id?'selected':''}}>{{$branch->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    @endif
        <div class="col-md-6">
            <div class="form-group">
                <label>service <span class="text-danger">*</span></label>
                <select name="service_id" class="default-select form-control wide" id="service_id" onchange="serviceChange(this)" required>
                    <option value="">Select Service</option>
                    @foreach($services as $service)
                        <option value="{{$service->id}}" data-price="{{$service->price}}" data-type="{{$service->discount_type}}" data-discount-val="{{$service->discount_value}}" {{$branch_service->service_id==$service->id?'selected':''}}>{{$service->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>

    </div>
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="form-group">
                <label>Price <span class="text-danger">*</span></label>
                <input type="number" class="form-control price"  name="price" value="{{ $branch_service->price}}" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Discount Type</label>
                <select name="discount_type"  class="default-select form-control wide discount_type" required>
                    <option value="">Select Discount Type</option>
                    <option value="0" {{$branch_service->discount_type==0?'selected':''}} >Fixed</option>
                    <option value="1" {{$branch_service->discount_type==1?'selected':''}}>Percentage</option>
                </select>
            </div>
        </div>

    </div>
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="form-group">
                <label>Discount Value <span class="text-danger">*</span></label>
                <input type="number" class="form-control discount_value"   name="discount_value" value="{{ $branch_service->discount_value}}" required>
            </div>
        </div>

    </div>

