@extends('layouts.app')
<input id="city" type="text">
<button id="cerca">Cerca</button>


@foreach ($services as $service)
    <label for="{{$service->name}}">{{$service->name}}</label>
    <input class="service" type="checkbox" name="services[{{$service->id}}]" value="{{$service->id}}" id="{{$service->name}}">
@endforeach


<label for="rooms">stanze</label>
<input id="rooms" type="text" placeholder="Stanze">

@section('script')
    <script src="{{asset('js/search.js')}}"></script>   
@endsection