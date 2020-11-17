@extends('layouts.app')


@section('content')
<div class="container search">


    
  <div class="form-group">
    <label for="city">Città</label>
    <input id="city" class="input-text" type="search" required placeholder="Dove vuoi andare?">
  </div>
  <div class="form-group">
    <label for="rooms">Numero minimo stanze</label>
    <input id="rooms" class="input-text" type="number" min="0" placeholder="Numero minimo stanze">
    <label for="beds">Numero minimo posti letto</label>
    <input id="beds" class="input-text" type="number" min="0" placeholder="Numero minimo letti">
  </div>
  <div class="form-group">
    @foreach ($services as $service)
        <label for="{{$service->id}}">{{$service->name}}</label>
        <input class="service" type="checkbox" name="services[{{$service->id}}]" value="{{$service->id}}" id="{{$service->id}}">
    @endforeach
  </div>
  <div class="form-group">
    <label for="distance">Distanza massima dal centro</label>
    <input type="range" id="distance" value="20" max="200">
    <span id="eccolo">20km</span>
  </div>
  
  <button class="btn" id="cerca">Cerca</button>
  <div id="results">

  </div>
    <script id="entry-template" type="text/x-handlebars-template">
        <div class="row apartment">
            <h4><a href="@{{route}}">@{{title}}</a></h4>
        </div>
    </script>
</div>
@endsection


@section('script')
    
    <script src="{{asset('js/search.js')}}"></script>   
@endsection