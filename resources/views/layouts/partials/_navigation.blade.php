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
                @auth
                    @tenant
                        <!-- Dashboard -->
                        <li class="nav-item">
                            <a class="nav-link{{ return_if(on_page('tenant.dashboard'), ' active') }}"
                                href="{{ route('tenant.dashboard') }}">
                                {{ __('Dashboard') }}
                            </a>
                        </li>
                        <!-- Projects -->
                        <li class="nav-item">
                            <a class="nav-link{{ return_if(on_page('tenant.projects.index'), ' active') }}"
                                href="{{ route('tenant.projects.index') }}">
                                {{ __('Projects') }}
                            </a>
                        </li>
                        <!-- Settings -->
                        <li class="nav-item">
                            <a class="nav-link{{ return_if(on_page('teams.show'), ' active') }}"
                                href="{{ route('teams.show', tenant()) }}">
                                {{ __('Settings') }}
                            </a>
                        </li>
                    @endtenant
                @endauth

                @notsubscribed
                    <li class="nav-item">
                        <a class="nav-link{{ return_if(on_page('plans.index'), ' active') }}"
                            href="{{ route('plans.index') }}">
                            {{ __('Pricing') }}
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
                            {{ __('Login') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link{{ return_if(on_page('register'), ' active') }}" href="{{ route('register') }}">
                            {{ __('Sign Up') }}
                        </a>
                    </li>
                @else
                    <!-- My Teams -->
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ __('My Teams') }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            @foreach ($teams as $team)
                                <a class="dropdown-item" href="{{ route('tenant.switch', $team) }}">
                                    {{ $team->name }}
                                </a>
                            @endforeach

                            @if ($teams->count())
                                <div class="dropdown-divider"></div>
                            @endif

                            <!-- Create New Team Link -->
                            <a class="dropdown-item" href="{{ route('teams.create') }}">
                                {{ __('New team') }}
                            </a>

                            {{-- @if ($teams->count())
                                <!-- View All Link -->
                                <a class="dropdown-item" href="{{ route('teams.index') }}">
                                    {{ __('View all') }}
                                </a>
                            @endif              --}}
                        </div>
                    </li>

                    <!-- My Dashboard -->
                    <li class="nav-item">
                        <a class="nav-link{{ return_if(on_page('account.dashboard'), ' active') }}"
                            href="{{ route('account.dashboard') }}">
                            {{ __('My Dashboard') }}
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
                                    {{ __('Stop Impersonating') }}
                                </a>
                                <form id="impersonate-form" action="{{ route('admin.users.impersonate.destroy') }}"
                                    method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            @endimpersonating

                            <!-- Admin Panel Link -->
                            @can('browse admin')
                                <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                    {{ __('Admin Panel') }}
                                </a>
                            @endcan

                            <!-- User Account Link -->
                            <a class="dropdown-item" href="{{ route('account.index') }}">
                                {{ __('My Account') }}
                            </a>

                            <!-- Developer Link -->
                            <a class="dropdown-item" href="{{ route('developer.index') }}">
                                {{ __('Developer Panel') }}
                            </a>
                            <div class="dropdown-divider"></div>

                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            @include('layouts.partials.forms._logout')
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
