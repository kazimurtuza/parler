
<div class="row mt-4">
    <div class="col-md-6">
        <div class="form-group">
            <label>Category</label>
            <select name="expense_category_id" id="discount_type" class="form-control" required>
                <option value="">-SELECT-</option>
                @foreach($categorys as $category)
                    <option value="{{$category->id}}" {{$category->id==$subcategory->expense_category_id?'selected':''}}>{{$category->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Subcategory Name <span class="text-danger">*</span></label>
            <input type="text" id="name" class="form-control" name="name" value="{{ $subcategory->name }}" required>
        </div>
    </div>
</div>