@extends('layouts.app')

@section('title', 'Cerca un appartamento')
@section('content')
<div class="container search">


    
  <div class="form-group">
    <label for="city">Città</label>
    <input id="city" class="input-text" type="search" required placeholder="Dove vuoi andare?">
  </div>
  <div class="form-group">
    <label for="rooms">Numero minimo stanze <input id="rooms" class="input-text" type="number" min="0" placeholder="Numero minimo stanze"></label>
    <label for="beds">Numero minimo posti letto <input id="beds" class="input-text" type="number" min="0" placeholder="Numero minimo letti"></label>
  </div>
  <div class="form-group">
    @foreach ($services as $service)
        <label for="{{$service->id}}">{{$service->name}} <input class="service" type="checkbox" name="services[{{$service->id}}]" value="{{$service->id}}" id="{{$service->id}}"></label>
        
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
          <div class="left col-lg-8 col-sm-12 col-12">
            <h4><a href="@{{route}}">@{{title}}</a></h4>
            <p>@{{description}}</p>
            <p>@{{distance}}km dal centro</p>
          </div>
          <div class="right col-lg-4 col-sm-12 col-12">
            <img src="https://cdn.pixabay.com/photo/2016/09/22/11/55/kitchen-1687121_960_720.jpg" alt="@{{title}}-image">
          </div>
        </div>
    </script>
</div>
@endsection


@section('script')
    <script src="{{asset('js/search.js')}}"></script>   
@endsection