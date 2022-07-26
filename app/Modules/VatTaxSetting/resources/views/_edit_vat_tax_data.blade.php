<div class="row mt-4">
    <div class="col-md-12">
        <div class="form-group">
            <label>Title <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="title" value="{{ $vat->title }}" required>
        </div>
    </div>
</div>
<div class="row mt-4">
    <div class="col-md-12">
        <div class="form-group">
            <label>Vat Percent <span class="text-danger">*</span></label>
            <input type="number" class="form-control" name="vat_percent" value="{{$vat->vat_percent }}" required>
        </div>
    </div>
</div>
<div class="row mt-4">
    <div class="col-md-12">
        <div class="form-group">
            <label>Vat Maximum Amount <span class="text-danger">*</span></label>
            <input type="number" class="form-control" step="any" name="maximum_amount" value="{{$vat->maximum_amount}}" required>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-12">
        <div class="form-group">
            <label>Is Default Active<span class="text-danger">*</span></label>
            &nbsp; <input type="checkbox" class="form-check-input" value="1" name="is_default" id="exampleCheck1" {{$vat->is_default==1?'checked':''}}>

        </div>
    </div>
</div>
