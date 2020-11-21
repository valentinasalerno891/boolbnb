    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <div class="logo">
                    <img class="navbar-brand" src="https://cdn.freelogovectors.net/wp-content/uploads/2016/12/airbnb_logo.png" onclick="window.location='/home'"}}" alt="logo">
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
                        <i class="fas fa-user-circle"></i>
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
