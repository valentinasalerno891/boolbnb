@extends('layouts.app')


@section('content')
<div class="container">
        
<div>
<label for="city">città</label>
<input id="city" type="text" placeholder="Città">

<label for="rooms">numero stanze</label>
<input id="rooms" type="number" min="0" placeholder="Stanze">
</div>
<div>
@foreach ($services as $service)
    <label for="{{$service->id}}">{{$service->name}}</label>
    <input class="service" type="checkbox" name="services[{{$service->id}}]" value="{{$service->id}}" id="{{$service->id}}">
@endforeach
</div>
<button id="cerca">Cerca</button>
</div>
@endsection



@section('script')
    <script src="{{asset('js/search.js')}}"></script>   
@endsection