@if(!empty($employees))
    <option value="">Select Staff</option>
    @foreach($employees as $employee)
        <option value="{{$employee->id}}" data-photo="{{ asset($employee->default_photo) }}">{{$employee->user->full_name}}</option>
    @endforeach

@endif
