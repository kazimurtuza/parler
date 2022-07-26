<option value="">-SELECT</option>
@foreach($banks as $bank)
    <option value="{{$bank->id}}">{{$bank->name}}</option>
@endforeach