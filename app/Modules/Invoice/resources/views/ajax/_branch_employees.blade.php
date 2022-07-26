@if(count($employees) > 0)
    <option value="">Select</option>
    @foreach($employees as $employee)
        <option value="{{ $employee->id }}">{{ $employee->user->full_name }}</option>
    @endforeach
@else
    <option value="">No Employee Found</option>
@endif