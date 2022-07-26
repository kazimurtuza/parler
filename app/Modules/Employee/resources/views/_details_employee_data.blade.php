<div class="row g-1">
    <div class="col-sm-4 col-md-4">
        <div class="emp_details_left">
            <div class="row d-flex justify-content-center">
                <div class="col-sm-4 col-md-4 d-flex justify-content-center"><img class="emp_details_img"
                                                                                  src="{{asset($employee->photo)}}" alt="">
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 mt-3">
                    <div class="form-group">
                        <label>Name</label>
                        <input readonly type="text" class="form-control smrd" name="first_name" value="{{$employee->user->full_name}}">
                    </div>
                </div>
                <div class="col-md-12 mt-3">
                    <div class="form-group">
                        <label>Phone</label>
                        <input readonly type="text" class="form-control smrd" name="phone" value="{{ $employee->user->phone }}" required>

                    </div>
                </div>
                <div class="col-md-12 mt-3">
                    <div class="form-group">
                        <label>Email </label>
                        <input readonly type="email" class="form-control smrd" value="{{$employee->user->email}}" name="email">

                    </div>
                </div>
                <div class="col-md-12 mt-3">
                    <div class="form-group">
                        <label>Emergency Contact</label>
                        <input readonly type="text" name="contact_person_number" value="{{$employee->contact_person_number}}"
                               class="form-control smrd">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-8 col-md-8 emp_details_right">
        <div class="row">
            @if(isAdmin())
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Branch</label>
                        <div class="form-group">
                            <input readonly type="text" class="form-control" value="{{$employee->branch->name}}">

                        </div>

                    </div>
                </div>
            @endif
            <div class="col-md-4">
                <div class="form-group">
                    <label>Employee Type</label>
                    <input readonly type="text" class="form-control" value="{{$employee->type}}">



                </div>

            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Joining Date</label>
                    <input readonly type="text" class="form-control" value="{{$employee->joining_date}}">

                </div>
            </div>
        </div>


        <div class="row mt-4">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Gender</label>
                    <input readonly type="text" class="form-control" value="{{$employee->gender_text}}">

                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Marital Status</label>
                    <select name="marital_status" id="" class="form-control">
                        <option value="">-SELECT-</option>
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
                    <input readonly type="text" class="form-control" value="{{$employee->blood}}">

                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-4">
                <div class="form-group">
                    <label>DOB</label>
                    <input type="text" readonly value="{{$employee->dob}}" class="form-control">
                    @if($errors->has('dob'))
                        <span class="text-danger">{{ $errors->first('dob') }}</span>
                    @endif
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Nid No</label>
                    <input readonly type="text" name="nid_number" value="{{$employee->nid_number}}" class="form-control">

                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label>Salary Type </label>
                    <input type="text" class="form-control" value="{{$employee->salary_type_text}}">

                </div>
            </div>
        </div>
        <div class="row mt-4">

            <div class="col-md-4">
                <div class="form-group">
                    <label>Salary value</label>
                    <input readonly type="number" class="form-control" name="salary_value" value="{{$employee->salary_value}}"
                           required>
                    @if($errors->has('salary_value'))
                        <span class="text-danger">{{ $errors->first('salary_value') }}</span>
                    @endif
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label>Permanent Address</label>
                    <input readonly type="text" name="permanent_address" value="{{$employee->permanent_address}}"
                           class="form-control">

                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Contact Person</label>
                    <input readonly type="text" name="contact_person_name" value="{{$employee->contact_person_name}}"
                           class="form-control">

                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Address</label>
                    <textarea readonly name="address" id="" class="form-control" cols="30" rows="10"
                              name="address">{{$employee->address}}</textarea>

                </div>
            </div>
        </div>


    </div>
</div>

