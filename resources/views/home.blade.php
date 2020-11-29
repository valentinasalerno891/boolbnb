{{-- @dd($apartments) --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Case vacanze, alloggi, esperienze e luoghi - Boolbnb</title>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    {{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/5.13.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous"> --}}
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="icon" href="https://www.shareicon.net/data/512x512/2016/07/10/119904_airbnb_512x512.png">
</head>
<body>
    <div class="home-container">
        <header>
            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="container">
                    <div class="logo">
                        <img class="navbar-brand" src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/69/Airbnb_Logo_B%C3%A9lo.svg/1024px-Airbnb_Logo_B%C3%A9lo.svg.png" alt="logo">
                    </div>
                    <div class="mobile-menu">
                        <button class="hamburger navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span id="hamburger" class="navbar-toggler-icon"></span>
                        </button>
                        <div id="mobile" class="mobile hidden">
                            @guest
                                <a class="home-menu-a nav-link nav-item" href="{{ route('register') }}">Registrati</a>
                                <a class="home-menu-a" href="{{ route('login') }}">Accedi</a>
                            @endguest
                                <a class="home-menu-a" href="{{ route('apartments.create') }}">Nuovo Appartamento</a>
                            @auth
                                <a  class="home-menu-a" href="{{ route('messages.index') }}">Messaggi</a>
                                <a class="home-menu-a" href="{{ route('apartments.index') }}">Appartamenti</a>
                                <a  class="home-menu-a" href="{{ route('paymentNoId') }}">Sponsorizzazioni</a>
                                <a class="home-menu-a" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }} &nbsp; <i class="user-icon fas fa-user-circle"></i>
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            @endauth
                        </div>
                    </div>
                    <div class="home-menu collapse navbar-collapse desktop" id="navbarSupportedContent">
                        @guest
                            <a class="home-menu-a nav-link nav-item m-3" href="{{ route('register') }}">Registrati</a>
                            <a class="home-menu-a m-3" href="{{ route('login') }}">Accedi</a>
                        @endguest
                            <a class="home-menu-a m-3" href="{{ route('apartments.create') }}">Inserisci un Appartamento</a>
                        @auth
                            <a  class="home-menu-a m-3" href="{{ route('messages.index') }}">Messaggi</a>
                            <a class="home-menu-a m-3" href="{{ route('apartments.index') }}">Appartamenti</a>
                            <a  class="home-menu-a m-3" href="{{ route('paymentNoId') }}">Sponsorizzazioni</a>
                            <a class="home-menu-a m-3" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                            <i class="user-icon fas fa-user-circle"></i>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        @endauth
                    </div>
                </div>
            </nav>
        </header>
        <div class="container">
            <div class="search-container">
                <div class="container search-nav">
                    <div class="ricerca città">
                        {{-- <span><strong>Dove</strong></span> --}}
                        <input id="city" name="city" placeholder="Dove vuoi andare?">
                    </div>
                    <div class="button-cerca">
                        <button id="myButton" type="button" name="cerca">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="title">
                <h1><strong>Riscopri la bellezza dell'Italia</strong></h1>
                <p>Scopri alloggi nelle vicinanze tutti da vivere, per lavoro o svago.</p>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="card-containerbool">
            <h2>Appartamenti in evidenza</h2>
            <div class="card-groupbool">
            @foreach ($apartments as $apartment)
                <div class="cardbool">
                    <div class="img-container">
                        <a href="{{route('apartments.show', $apartment->id)}}"><img class="card-img-top" src="{{Storage::url($apartment->image)}}" alt="img"></a>
                    </div>
                    <div class="card-body p-0 pt-3">
                        <h5 class="text-break card-title"><a href="{{route('apartments.show', $apartment->id)}}">{{$apartment->title}}</a></h5>
                        <p class="text-break card-text">{{$apartment->city}}</p>
                        <p class="text-break card-text">{{$apartment->description}}</p>
                    </div>
                </div>
            @endforeach

            </div>
        </div>
    </div>

    @include('template.footer')
    <script src="{{asset('js/homeSearch.js')}}"></script>
</body>
</html>
