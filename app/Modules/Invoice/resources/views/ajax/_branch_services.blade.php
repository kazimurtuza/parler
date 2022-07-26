@if(count($services) > 0)
    <option value="">Select</option>
    @foreach($services as $service)
        <option value="{{ $service->id }}" data-discount-value="{{$service->discount_value}}" data-discount-type="{{$service->discount_type}}" data-price="{{$service->service->price}}">{{ $service->service->name }}</option>
    @endforeach
@else
    <option value="">No Service Found</option>
@endif