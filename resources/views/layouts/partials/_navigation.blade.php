<nav class="navbar navbar-expand-md navbar-light navbar-laravel">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
                @notsubscribed
                <li class="nav-item">
                    <a class="nav-link{{ return_if(on_page('plans.index'), ' active') }}"
                       href="{{ route('plans.index') }}">
                        Pricing
                    </a>
                </li>
                @endnotsubscribed
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link{{ return_if(on_page('login'), ' active') }}" href="{{ route('login') }}">
                            Login
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link{{ return_if(on_page('register'), ' active') }}"
                           href="{{ route('register') }}">
                            Sign Up
                        </a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link{{ return_if(on_page('account.dashboard'), ' active') }}"
                           href="{{ route('account.dashboard') }}">
                            My Dashboard
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <!-- Impersonating -->
                            @impersonating
                            <a class="dropdown-item" href="#"
                               onclick="event.preventDefault(); document.getElementById('impersonate-form').submit();">
                                Stop Impersonating
                            </a>
                            <form id="impersonate-form" action="{{ route('admin.users.impersonate.destroy') }}"
                                  method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                            @endimpersonating

                            <!-- Admin Panel Link -->
                            @role('admin')
                            <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                Admin Panel
                            </a>
                            @endrole

                            <!-- User Account Link -->
                            <a class="dropdown-item" href="{{ route('account.index') }}">
                                My Account
                            </a>

                            <!-- Developer Link -->
                            <a class="dropdown-item" href="{{ route('developer.index') }}">
                                Developer Panel
                            </a>
                            <div class="dropdown-divider"></div>

                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                Logout
                            </a>

                            @include('layouts.partials.forms._logout')
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
