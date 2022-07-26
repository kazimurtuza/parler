@if(!empty($services))
    <option value="">-SELECT-</option>
    @foreach($services as $service)
        <option value="{{$service->id}}" data-price="{{$service->price}}" data-type="{{$service->discount_type}}" data-discount-val="{{$service->discount_value}}">{{$service->name}}</option>
    @endforeach
@endif