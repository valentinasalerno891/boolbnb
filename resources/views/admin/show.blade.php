@extends('layouts.app')
<link rel='stylesheet' type='text/css' href='https://api.tomtom.com/maps-sdk-for-web/cdn/5.x/5.64.0/maps/maps.css'>
@section('content')
  <div class="apartment_show">
    <div class="container">
      <div class="header_apartment">
        <span class="title">{{$apartment->title}}</span>
        <div class="apartment_form">    
          @if ($apartment->user_id == Auth::id())
          <div class="big-display">
            <span class="mr-3"><a href="{{route('apartments.edit',$apartment->id)}}"><i class="far fa-edit"></i> Modifica</a></span>
            <span class="mr-3"><a href="{{route('stats.show',$apartment->id)}}"><i class="far fa-chart-bar"></i> Statistiche</a></span>
            <form action="{{route('apartments.destroy',$apartment->id)}}" method="post">
                @csrf
                @method('DELETE')
                <button class="btn bool-btn-pink" type="submit"><span>Delete <i class="far fa-trash-alt"></i></span></button>
            </form>
          </div>
          <div class="small-display">
            <span><a href="{{route('apartments.edit',$apartment->id)}}"><i class="far fa-edit"></i></a></span>
            <span><a href="{{route('stats.show',$apartment->id)}}"><i class="far fa-chart-bar"></i></a></span>
            <form action="{{route('apartments.destroy',$apartment->id)}}" method="post">
                @csrf
                @method('DELETE')
                <button class="btn bool-btn-pink" type="submit"><span><i class="far fa-trash-alt"></i></span></button>
            </form>
          </div>
          @endif
        </div>  
      </div> 
      <div class="image_apartment">
        <img src="https://media.istockphoto.com/photos/evening-view-of-a-modern-house-with-swimming-pool-picture-id1151833014" alt="apartment">  
      </div> 
      <hr>
      <div class="description_information">
        <div class="apartment_description">
          <h3>DESCRIZIONE APPARTAMENTO</h3>
          <span>{{$apartment->description}}</span>
        </div>
        <hr>
        <div class="apartment_information">
          <h3>INFORMAZIONI APPARTAMENTO</h3>
          <p class="">Metri quadri appartamento : {{$apartment->square_meters}}</p>
          <p class="">Camere : {{$apartment->rooms}} <i class="fas fa-door-open"></i></p>
          <p class="">Letti : {{$apartment->beds}} <i class="fas fa-bed"></i></p>
          <p class="">Bagni : {{$apartment->bathrooms}} <i class="fas fa-bath"></i></p>
          <p class="">Proprietario : {{$apartment->user->name}} {{$apartment->user->lastname}} <i class="fas fa-user"></i></p>
        </div>
      </div>
      <hr>
      <div class="service_maps"> 
        <div class="apartment_service">
          <h3>SERVIZI APPARTAMENTO</h3>
          <ul>
            @foreach ($apartment->services  as $service)
              @switch($service->id)
              @case($service->id==1)
              <li><i class="fas fa-wifi"></i>{{$service->name}}</li>
              @break
              @case($service->id==2)
              <li><i class="fas fa-car"></i>{{$service->name}}</li>
              @break
              @case($service->id==3)
                <li><i class="fas fa-swimmer"></i> {{$service->name}}</li>
              @break
              @case($service->id==4)
              <li><i class="fas fa-door-open"></i> {{$service->name}}</li>
              @break
              @case($service->id==5)
              <li><i class="fas fa-hot-tub"></i> {{$service->name}}</li>
              @break
              @case($service->id==6)
              <li><i class="fas fa-water"></i> {{$service->name}}</li>
              @break
              @default
                <li>NESSUN SERVIZIO PRESENTE</li>
              @endswitch
            @endforeach
          </ul>
        </div>
        <hr>
        <div id="map" class="map apartment_maps"></div>
      </div>
      <hr>         
      @if ($apartment->user_id != Auth::id()) 
      @if (session('status'))
      <div class="alert alert-success">
          {{ session('status') }}
      </div>
      @endif
      <form class="message" action="{{route('messages.store',$apartment->id)}}" method="post">
        @csrf
        @method('POST')
      <div class="form-group">
        <label for="email">Email</label>
        @auth
          <input name="email" type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Inserisci la tua email" value="{{Auth::user()->email}}">
        @endauth
        @guest
            <input name="email" type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Inserisci la tua email">
        @endguest
      </div>
      <div class="form-group">
        <label for="title">Oggetto</label>
        <input name="title" type="text" class="form-control" id="title" placeholder="Inserisci il titolo">
      </div>
      <div class="form-group">
        <label for="body">Messaggio</label>
        <input name="body" type="text" class="form-control" id="body" placeholder="Inserisci il messaggio">
      </div>
      <button type="submit" class="btn bool-btn-pink">Submit <i class="far fa-paper-plane"></i></button>
      </form>
      <hr>
      @endif
    </div>
  </div>  
@endsection


@section('script')
    <script src="https://api.tomtom.com/maps-sdk-for-web/cdn/5.x/5.64.0/maps/maps-web.min.js"></script>
    <script>
        var longitude = {!! $apartment->longitude !!};
        var latitude = {!! $apartment->latitude !!};
        var map = tt.map({
            key: "wBFrGupwgm95n0TA2HmZJULQ5GktiGhQ",
            center: [longitude,latitude],
            zoom: 11,
            container: "map",
            style: "tomtom://vector/1/basic-main",
            theme: {
                style: 'main',
                layer: 'basic',
                source: 'vector',
            }
        });
        map.addControl(new tt.NavigationControl());
   </script>
@endsection