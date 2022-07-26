@if($customers)
    @foreach($customers as $customer)
        <option value="{{$customer->id}}"  customer-blance="{{$customer->available_balance}}"
                customer-disval="{{$customer->membership->discount_value}}"
                customer-disType="{{$customer->membership->discount_type}}" {{$customer_id==$customer->id?'selected':''}}>{{$customer->full_name}}</option>
    @endforeach
@endif