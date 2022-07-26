@if(!empty($banklists))
    <option value="">Payment Method</option>
    @foreach($banklists as $bank)
        <option value="{{$bank->id}}">{{$bank->name}}</option>
    @endforeach
@endif
