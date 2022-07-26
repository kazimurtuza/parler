<tr>
    <th scope="row" class="si">1</th>
    <td>
        <select name="product_id[]" class="form-control product default-select" required>
            <option value="">-SELECT-</option>
            @foreach($products as $product)
                <option value="{{$product->id}}" data-unitprice="{{$product->price}}">{{$product->name}}</option>
            @endforeach
        </select>
    </td>
    <td><input type="number" min="1" value="0"  step="any" name="price[]" class="form-control price"></td>
    <td><input type="number" min="0" value="1"  step="any" name="quantity[]" class="form-control quantity"></td>
    <td><span class="total">178</span></td>
</tr>