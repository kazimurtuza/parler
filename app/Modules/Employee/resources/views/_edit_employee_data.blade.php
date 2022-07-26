<div class="row mb-4">
    <div class="col-12">
        <div class="form-title-wrapper">
            <span class="emptitle">Basic information</span>
        </div>
    </div>
</div>

<div class="row">
    @if(isAdmin())
        <div class="col-md-4">
            <div class="form-group">
                <label>Branch <span class="text-danger">*</span></label>
                <select class="default-select form-control wide" name="branch_id" value="{{old('branch_id')}}" id="" required>
                    <option value="">Select Branch</option>
                    @foreach($branch as $branch_data)
                        <option value="{{$branch_data->id}}" {{$branch_data->id==$employee->branch_id?'selected':''}}>{{$branch_data->name}}</option>
                    @endforeach

                </select>
                @if($errors->has('branch_id'))
                    <span class="text-danger">{{ $errors->first('branch_id') }}</span>
                @endif

            </div>
        </div>
    @endif
    <div class="col-md-4">
        <div class="form-group">
            <label>Employee Type <span class="text-danger">*</span></label>
            <select name="type" class="default-select form-control wide" id="" required>
                <option value="">Select Employee Type</option>
                @if(isAdmin())
                    <option value="manager" {{'manager'==$employee->type?'selected':''}}>Manager</option>
                @endif
                <option value="storekeeper" {{'storekeeper'==$employee->type?'selected':''}}>Store Keeper</option>
                <option value="accountant" {{'accountant'==$employee->type?'selected':''}}>Accountant</option>
                <option value="staff" {{'staff'==$employee->type?'selected':''}}>Staff</option>
            </select>

        </div>
        @if($errors->has('type'))
            <span class="text-danger">{{ $errors->first('type') }}</span>
        @endif
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Joining Date <span class="text-danger">*</span></label>
            <input type="date" class="mdate form-control" value="{{$employee->joining_date}}" name="joining_date" required>
            @if($errors->has('joining_date'))
                <span class="text-danger">{{ $errors->first('joining_date') }}</span>
            @endif
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-8">
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="form-group">
                    <label>First Name<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="first_name" value="{{$employee->user->first_name}}" required>
                    @if($errors->has('first_name'))
                        <span class="text-danger">{{ $errors->first('first_name') }}</span>
                    @endif
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label>Last Name<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="last_name" value="{{$employee->user->last_name}}" required>

                    @if($errors->has('last_name'))
                        <span class="text-danger">{{ $errors->first('last_name') }}</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Phone <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="phone" value="{{ $employee->user->phone }}" required>

                    @if($errors->has('phone'))
                        <span class="text-danger">{{ $errors->first('phone') }}</span>
                    @endif
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Email </label>
                    <input type="email" class="form-control" value="{{$employee->user->email}}" name="email">

                    @if($errors->has('email'))
                        <span class="text-danger">{{ $errors->first('email') }}</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group dropify-with-input mt-4">
            <label>Photo</label>
            <input type="file" name="photo" class="dropify form-control" accept="image/*" data-height="120" data-default-file="{{ asset($employee->default_photo) }}">
            @if($errors->has('photo'))
                <span class="text-danger">{{ $errors->first('photo') }}</span>
            @endif
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-4">
        <div class="form-group">
            <label>Password </label>
            <input type="password" class="form-control" value="" name="password">

            @if($errors->has('password'))
                <span class="text-danger">{{ $errors->first('password') }}</span>
            @endif
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label>Salary Type <span class="text-danger">*</span></label>
            <select class="default-select form-control wide" name="salary_type" value="{{old('salary_type')}}" id=""
                    required>

                <option value="">--SELECT--</option>
                <option value="0" {{$employee->salary_type==0?'selected':''}}>Commission Based</option>
                <option value="1"{{$employee->salary_type==1?'selected':''}}>Salary Based</option>
            </select>
            @if($errors->has('salary_type'))
                <span class="text-danger">{{ $errors->first('salary_type') }}</span>
            @endif
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Salary value <span class="text-danger">*</span></label>
            <input type="number" class="form-control" name="salary_value" value="{{$employee->salary_value}}" required>
            @if($errors->has('salary_value'))
                <span class="text-danger">{{ $errors->first('salary_value') }}</span>
            @endif
        </div>
    </div>
</div>

<div class="row mb-4 mt-5">
    <div class="col-12">
        <div class="form-title-wrapper">
            <span class="emptitle">Other Info</span>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-4">
        <div class="form-group">
            <label>Gender <span class="text-danger">*</span></label>
            <select name="gender" id="" class="default-select form-control wide">
                <option value="">Select Gender</option>
                <option value="0"{{$employee->gender==0 ?'selected':''}}>Male</option>
                <option value="1" {{$employee->gender==1 ?'selected':''}}>Female</option>
                <option value="2" {{$employee->gender==2 ?'selected':''}}>Others</option>
            </select>
            @if($errors->has('gender'))
                <span class="text-danger">{{ $errors->first('gender') }}</span>
            @endif
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Marital Status</label>
            <select name="marital_status" id="" class="default-select form-control wide">
                <option value="">Select Marital Status</option>
                <option value="1" {{$employee->marital_status==1 ?'selected':''}}>Married</option>
                <option value="0" {{$employee->marital_status==0 ?'selected':''}}>Unmarried</option>
            </select>
            @if($errors->has('marital_status'))
                <span class="text-danger">{{ $errors->first('marital_status') }}</span>
            @endif
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Blood Group</label>
            <select name="blood" class="default-select form-control wide">
                <option value="">Select Blood Group</option>
                @if(!empty($blood_groups))
                    @foreach($blood_groups as $blood_group)
                        <option value="{{ $blood_group }}" {{ ($employee->blood == $blood_group)?'selected':'' }}>{{ $blood_group }}</option>
                    @endforeach
                @endif
            </select>
            @if($errors->has('blood'))
                <span class="text-danger">{{ $errors->first('blood') }}</span>
            @endif
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="form-group">
            <label>DOB</label>
            <input type="date" name="dob" value="{{$employee->dob}}" class="mdate form-control">
            @if($errors->has('dob'))
                <span class="text-danger">{{ $errors->first('dob') }}</span>
            @endif
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Nid No</label>
            <input type="text" name="nid_number" value="{{$employee->nid_number}}" class="form-control">
            @if($errors->has('nid_number'))
                <span class="text-danger">{{ $errors->first('nid_number') }}</span>
            @endif
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="form-group">
            <label>Address</label>
            <textarea name="address" id="" class="form-control" cols="30" rows="10"
                      name="address">{{$employee->address}}</textarea>

            @if($errors->has('address'))
                <span class="text-danger">{{ $errors->first('address') }}</span>
            @endif
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Permanent Address</label>
            <input type="text" name="permanent_address" value="{{$employee->permanent_address}}" class="form-control">
            @if($errors->has('permanent_address'))
                <span class="text-danger">{{ $errors->first('permanent_address') }}</span>
            @endif
        </div>
    </div>
</div>
<div class="row mt-4">
    <div class="col-md-6">
        <div class="form-group">
            <label>Contact Person Name</label>
            <input type="text" name="contact_person_name" value="{{$employee->contact_person_name}}"
                   class="form-control">
            @if($errors->has('contact_person_name'))
                <span class="text-danger">{{ $errors->first('contact_person_name') }}</span>
            @endif
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Contact Person number</label>
            <input type="text" name="contact_person_number" value="{{$employee->contact_person_number}}"
                   class="form-control">
            @if($errors->has('contact_person_number'))
                <span class="text-danger">{{ $errors->first('contact_person_number') }}</span>
            @endif
        </div>
    </div>
</div>
