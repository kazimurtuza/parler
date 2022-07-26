<div class="row">
    @if(isAdmin())
    <div class="col-md-12">
        <div class="form-group">
            <label>Branch <span class="text-danger">*</span></label>
            <select name="branch_id" class="form-control " onchange="branchid(this.value)" id="branch_id2" required>
                <option value="">-SELECT-</option>
                @foreach($branches as $branch)
                    <option value="{{$branch->id}}" {{$expense->branch_id==$branch->id?'selected':''}}>{{$branch->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
        @endif
</div>
<div class="row mt-4">
    <div class="col-md-12">
        <div class="form-group">
            <label>Category <span class="text-danger">*</span></label>
            <select name="expense_category_id" class="form-control" id="category_id2" onchange="categoryid(this)" required>
                <option value="">-SELECT-</option>
                @foreach($categories as $category)
                    <option value="{{$category->id}}" {{$expense->expense_category_id==$category->id?'selected':''}}>{{$category->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
<div class="row mt-4">
    <div class="col-md-12">
        <div class="form-group">
            <label>Subcategory <span class="text-danger">*</span></label>
            <select name="expense_sub_category_id" class="form-control subcategory_id" id="subcategory_id_edit"
                    required>
                @foreach($subcategories as $subcategory)
                    <option value="{{$subcategory->id}}" {{$expense->expense_sub_category_id==$subcategory->id?'selected':''}}>{{$subcategory->name}}</option>
                @endforeach

            </select>
        </div>
    </div>
</div>
<div class="row mt-4">
    <div class="col-md-12">
        <div class="form-group">
            <label>Amount <span class="text-danger">*</span></label>
            <input type="number" name="amount" value="{{$expense->amount}}" class="form-control">
        </div>
    </div>
</div>
<div class="row mt-4">
    <div class="col-md-12">
        <div class="form-group">
            <label>Date <span class="text-danger">*</span></label>
            <input type="datetime-local" name="datetime" value="{{ strftime('%Y-%m-%dT%H:%M:%S', strtotime($expense->datetime)) }}" class="form-control" required>
        </div>
    </div>
</div>
<div class="row mt-4">
    <div class="col-md-12">
        <div class="form-group">
            <label>Employee <span class="text-danger">*</span></label>
            <select name="employee_id" class="form-control employee_id" id="employee_edit" required>
                @foreach($employees as $employee)
                    <option value="{{$employee->id}}" {{$expense->employee_id==$employee->id?'selected':''}}>{{$employee->user->full_name}}</option>
                @endforeach

            </select>
        </div>

    </div>

</div>
<div class="row mt-4">
    <div class="col-md-12">
        <div class="form-group">
            <label>Note </label>
            <textarea name="note" class="form-control" id="" cols="30"
                      rows="10">{{$expense->note}}</textarea>
        </div>
    </div>
</div>
