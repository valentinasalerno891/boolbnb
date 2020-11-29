    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <div class="logo">
                    <img class="navbar-brand pointer" src="https://cdn.freelogovectors.net/wp-content/uploads/2016/12/airbnb_logo.png" onclick="window.location='/'"}} alt="logo">
                </div>

                <div class="mobile-menu">
                    {{-- id="hamburger1" --}}
                    <button class="hamburger1 navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
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
                            {{-- <i class="fas fa-user-circle"></i> --}}
                            <a class="home-menu-a" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                {{ __('Logout') }} &nbsp; <i id="user-icon" class="fas fa-user-circle"></i>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        @endauth
                    </div>
                </div>
                <div class="home-menu collapse navbar-collapse desktop">
                    @guest
                        <a class="home-menu-a nav-link nav-item" href="{{ route('register') }}">Registrati</a>
                        <a class="home-menu-a m-3" href="{{ route('login') }}">Accedi</a>
                    @endguest
                        <a class="home-menu-a m-3" href="{{ route('apartments.create') }}">Nuovo Appartamento</a>
                    @auth
                        <a  class="home-menu-a m-3" href="{{ route('messages.index') }}">Messaggi</a>
                        <a class="home-menu-a m-3" href="{{ route('apartments.index') }}">Appartamenti</a>
                        <a  class="home-menu-a m-3" href="{{ route('paymentNoId') }}">Sponsorizzazioni</a>
                        <a class="home-menu-a m-3" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>
                        <i class="fas fa-user-circle"></i>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    @endauth
                </div>
            </div>
        </nav>
        {{-- <script type="text/javascript">
        $( ".hamburger1" ).click(function() {
            alert();
          $( "#mobile" ).toggleClass("hidden");
        });

        </script> --}}
    </header>
