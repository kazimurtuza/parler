@if(count($customers) > 0)
    <option value="">Select</option>
    <option data-addcustomer="add">+ Add Customer</option>
    @foreach($customers as $customer)
        <option value="{{ $customer->id }}">{{ $customer->full_name }}</option>
    @endforeach
@else
    <option value="">No Customer Found</option>
@endif