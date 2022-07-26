<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>First Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="first_name" value="{{$customer->first_name}}" required>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Last Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="last_name" value="{{$customer->last_name}}" required>
        </div>
    </div>
</div>
<div class="row mt-4">
    <div class="col-md-6">
        <div class="form-group">
            <label>Membership<span class="text-danger">*</span></label>
            <select name="customer_membership_id" class="default-select form-control wide" required>
                <option value="">Select Membership</option>
                @foreach($memberships as $membership)
                    <option value="{{$membership->id}}" {{$customer->customer_membership_id==$membership->id?'selected':''}}>{{$membership->title}}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label>DOB</label>
            <input type="date" class="mdate form-control" name="dob" value="{{ $customer->dob }}">
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="form-group">
            <label>Phone <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="phone" value="{{$customer->phone}}" required>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Email </label>
            <input type="text" class="form-control" name="email" value="{{$customer->email}}">
        </div>
    </div>

</div>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="form-group">
            <label>Gender</label>
            <select class="default-select form-control wide" name="gender">
                <option value="">Select Gender</option>
                <option value="0" {{$customer->gender==0?'selected':''}}>Male</option>
                <option value="1" {{$customer->gender==1?'selected':''}}>Female</option>
                <option value="2" {{$customer->gender==2?'selected':''}}>Others</option>
            </select>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Blood Group</label>
            <select name="blood" class="default-select form-control wide">
                <option value="">Select Blood Group</option>
                @if(!empty($blood_groups))
                    @foreach($blood_groups as $blood_group)
                        <option
                            value="{{ $blood_group }}" {{ ($customer->blood == $blood_group)?'selected':'' }}>{{ $blood_group }}</option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>
</div>
<div class="row mt-4">
    <div class="col-md-12">
        <div class="form-group">
            <label>Address</label>
            <textarea class="form-control" name="address" cols="30" rows="10">{{$customer->address}}</textarea>
        </div>
    </div>
</div>
<div class="row mt-4">
    <div class="col-12">
        <div class="form-group">
            <label>Photo</label>
            <input type="file" class="dropify form-control" name="photo"  data-height="100" data-default-file="{{ asset($customer->default_photo) }}">
        </div>
    </div>
</div>
