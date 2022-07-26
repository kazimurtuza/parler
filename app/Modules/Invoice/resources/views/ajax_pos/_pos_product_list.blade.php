@if(!empty($services))

    @foreach($services as $service)
        <div class="col-sm-3 col-6  pos-single-service">
            <div class="card" data-productId="{{$service->id}}"  data-price="{{$service->price}}" data-discountType-val="{{$service->discount_type}}" data-discountType="{{$service->discount_type_text}}" data-discountVal="{{$service->discount_value}}" data-name="{{$service->service->name}}" data-image="{{$service->service->default_image}}" onclick="addProduct(this)">
                <div class="card-body">
                    <div class="pos-image">
                        <img class="posImg" src="{{asset($service->service->default_image)}}" alt="{{$service->service->name}}">
                    </div>
                    <div class="pos-service-name">
                        <p>{{$service->service->name}}</p>
                    </div>
                    <div class="pos-service-price">
                        <p>{{ \App\Helpers\CommonHelper::getCurrency()['symble'] }} {{$service->service->price}}</p>
                    </div>
                </div>
            </div>
        </div>
        {{--<div class="col-sm-6">
            <div class="row posCard crpoin" data-productId="{{$service->service->id}}"  data-price="{{$service->price}}" data-discountType-val="{{$service->discount_type}}" data-discountType="{{$service->discount_type_text}}" data-discountVal="{{$service->discount_value}}" data-name="{{$service->service->name}}" onclick="addProduct(this)">
                <div class="col-sm-4">

                </div>
                <div class="col-sm-8 p-1 text-center">
                    <strong></strong> <br>
                    <strong>price: BDT</strong> <br>
                </div>
            </div>
        </div>--}}
    @endforeach

@endif
