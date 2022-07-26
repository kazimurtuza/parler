<option value="">-SELECT</option>
@foreach($employees as $employee)
    <option value="{{$employee->id}}">{{$employee->user->full_name}}</option>
@endforeach