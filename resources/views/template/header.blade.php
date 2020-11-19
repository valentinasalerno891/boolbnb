    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <div class="logo">
                    <img class="navbar-brand" src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/69/Airbnb_Logo_B%C3%A9lo.svg/1024px-Airbnb_Logo_B%C3%A9lo.svg.png" alt="logo">
                </div>
                {{-- <span class="navbar-brand">BoolBnB</span> --}}
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="home-menu collapse navbar-collapse" id="navbarSupportedContent">
                    @guest
                        <a class="home-menu-a nav-link nav-item m-3" href="{{ route('register') }}">Registrati</a>
                        <a class="home-menu-a m-3" href="{{ route('login') }}">Login</a>
                    @endguest
                        <a class="home-menu-a m-3" href="{{ route('apartments.create') }}">Inserisci un appartamento</a>
                    @auth
                        <a  class="home-menu-a m-3" href="{{ route('messages.index') }}">Messaggi</a>
                        <a class="home-menu-a m-3" href="{{ route('apartments.index') }}">Appartamenti</a>
                        <a class="home-menu-a" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    @endauth
                </div>
            </div>
        </nav>
    </header>
