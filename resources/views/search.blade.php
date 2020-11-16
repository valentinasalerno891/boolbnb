@extends('layouts.app')


@section('content')
<div class="container">
        
<div>
<label for="city">città</label>
<input id="city" type="search" placeholder="Città">

<label for="rooms">numero minimo stanze</label>
<input id="rooms" type="number" min="0" placeholder="Numero minimo stanze">
<label for="beds">numero minimo posti letto</label>
<input id="beds" type="number" min="0" placeholder="Numero minimo letti">
</div>
<div>
@foreach ($services as $service)
    <label for="{{$service->id}}">{{$service->name}}</label>
    <input class="service" type="checkbox" name="services[{{$service->id}}]" value="{{$service->id}}" id="{{$service->id}}">
@endforeach
</div>
<label for="distance">Distanza massima dal centro</label>
<input type="range" id="distance" value="20" max="200">
<span id="eccolo">20km</span>

<div>
    <button id="cerca">Cerca</button>
</div>
</div>
@endsection



@section('script')
    <script src="{{asset('js/search.js')}}"></script>   
@endsection