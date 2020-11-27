
@extends('layouts.app')
<link rel='stylesheet' type='text/css' href='https://api.tomtom.com/maps-sdk-for-web/cdn/5.x/5.64.0/maps/maps.css'>
@section('title', $apartment->title)
@section('content')
  <div class="apartment_show">
    <div class="container">
      @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
          @endif
          @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
          @endif
        <div class="header_apartment">
        <span class="title">{{$apartment->title}}</span>
        <div class="apartment_form">
          @if ($apartment->user_id == Auth::id())
          <div class="big-display">
            <span class="mr-3"><a href="{{route('apartments.edit',$apartment->id)}}"><i class="far fa-edit"></i> Modifica</a></span>
            <span class="mr-3"><a href="{{route('stats.show',$apartment->id)}}"><i class="far fa-chart-bar"></i> Statistiche</a></span>
            <span class="mr-3"><a href="{{route('paymentWithId',$apartment->id)}}"><i class="fas fa-shopping-cart"></i> Sponsorizza</a></span>
            <form action="{{route('apartments.destroy',$apartment->id)}}" method="post">
                @csrf
                @method('DELETE')
                <button class="btn bool-btn-pink" type="submit"><span>Delete <i class="far fa-trash-alt"></i></span></button>
            </form>
          </div>
          <div class="small-display">
            <span><a href="{{route('apartments.edit',$apartment->id)}}"><i class="far fa-edit"></i></a></span>
            <span><a href="{{route('stats.show',$apartment->id)}}"><i class="far fa-chart-bar"></i></a></span>
            <span class="mr-3"><a href="{{route('paymentWithId',$apartment->id)}}"><i class="fas fa-shopping-cart"></i></a></span>
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
        <img src="{{Storage::url($apartment->image)}}" alt="apartment-image">
      </div>
      <hr>
      <div class="description_information">
        <div class="apartment_description">
          <h3>DESCRIZIONE APPARTAMENTO</h3>
          <span class="text-break">{{$apartment->description}}</span>
        </div>
        {{-- <hr> --}}
        <div class="apartment_information">
          <h3>DETTAGLI APPARTAMENTO</h3>
          <p class="">Metri quadri appartamento: {{$apartment->square_meters}}</p>
          <p class=""><span class="cookies"><i class="fas fa-door-open"></i></span> Camere: {{$apartment->rooms}}</p>
          <p class=""><span class="cookies"><i class="fas fa-bed"></i></span> Letti: {{$apartment->beds}}</p>
          <p class=""><span class="cookies"><i class="fas fa-bath"></i></span> Bagni: {{$apartment->bathrooms}}</p>
          @if ($apartment->user->name || $apartment->user->lastname)
              <p class=""><span class="cookies"><i class="fas fa-user"></i></span> Proprietario: {{$apartment->user->name}} {{$apartment->user->lastname}}</p>
          @endif
        </div>
      </div>
      <hr>
      <div class="service_maps">
        <div class="apartment_service">
          <h3>SERVIZI AGGIUNTIVI APPARTAMENTO</h3>
          <ul>
            @isset($apartment->services[0])
              @foreach ($apartment->services as $service)
              @switch($service->id)
              @case($service->id==1)
              <li><span class="cookies"><i class="fas fa-wifi"></i></span>{{$service->name}}</li>
              @break
              @case($service->id==2)
              <li><span class="cookies"><i class="fas fa-car"></i></span>{{$service->name}}</li>
              @break
              @case($service->id==3)
                <li><span class="cookies"><i class="fas fa-swimmer"></i></span>{{$service->name}}</li>
              @break
              @case($service->id==4)
              <li><span class="cookies"><i class="fas fa-door-open"></span></i>{{$service->name}}</li>
              @break
              @case($service->id==5)
              <li><span class="cookies"><i class="fas fa-hot-tub"></i></span>{{$service->name}}</li>
              @break
              @case($service->id==6)
              <li><i class="fas fa-water"></i> {{$service->name}}</li>
              @break
              @default
              <li>NESSUN SERVIZIO AGGIUNTIVO PRESENTE</li>
              @endswitch
            @endforeach
            @else
            <li>NESSUN SERVIZIO AGGIUNTIVO PRESENTE</li>
            @endisset
          </ul>
        </div>
        {{-- <hr> --}}
        <div id="map" class="map apartment_maps"></div>
      </div>
      <hr>
      @if ($apartment->user_id != Auth::id())
      <form class="message" action="{{route('messages.store',$apartment->id)}}" method="post">
        @csrf
        @method('POST')
      <div class="form-group">
        <label for="email">Email</label>
        @auth
          <input name="email" type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Inserisci la tua email" value="{{Auth::user()->email}}">
        @endauth
        @guest
            <input name="email" type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Inserisci la tua email" value="{{old('email')}}">
        @endguest
      </div>
      <div class="form-group">
        <label for="title">Oggetto</label>
        <input name="title" type="text" class="form-control" id="title" placeholder="Inserisci il titolo" value="{{old('title')}}">
      </div>
      <div class="form-group">
        <label for="body">Messaggio</label>
        <textarea name="body" type="text" class="form-control" id="body" placeholder="Inserisci il messaggio">{{old('body')}}</textarea>
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
