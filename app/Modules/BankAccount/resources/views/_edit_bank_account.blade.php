@if(isAdmin())
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label>Branch <span class="text-danger">*</span></label>
            <select name="branch_id" class="form-control" id="" required>
                <option value="">-SELECT-</option>
                @foreach($branches as $branch)
                    <option
                        value="{{$branch->id}}" {{$bankAccounts->branch_id==$branch->id?'selected':''}}>{{$branch->name}}</option>
                @endforeach

            </select>
        </div>
    </div>
</div>
@endif
<div class="row">
    <div class="col-md-12 mt-4">
        <div class="form-group">
            <label>Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="name" value="{{ $bankAccounts->name }}" required>
        </div>
    </div>
</div>
<div class="row mt-4">
    <div class="col-md-12">
        <div class="form-group">
            <label>Account No <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="account_no" value="{{ $bankAccounts->account_no }}" required>
        </div>
    </div>
</div>
<div class="row mt-4">
    <div class="col-md-12">
        <div class="form-group">
            <label>Opening Balance <span class="text-danger">*</span></label>
            <input type="number" class="form-control" min="0" name="opening_balance"
                   value="{{ $bankAccounts->opening_balance }}">
        </div>
    </div>
</div>


