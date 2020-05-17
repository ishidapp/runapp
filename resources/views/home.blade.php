<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Run App</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}?ver=1.1.2" rel="stylesheet">
</head>
<body>
    <div id="app">
        <header class="l-header">
            <div class="p-header">
                <div class="p-header__inner">
                    <a class="p-header__logo" href="{{ url('/') }}">Run App</a>
                    <nav class="p-header__nav">
                        <ul class="c-nav">
                            @guest
                                <li class="c-nav__item">
                                    <a class="c-nav__link" href="{{ route('login') }}">ログイン</a>
                                </li>
                                @if (Route::has('register'))
                                    <li class="c-nav__item">
                                        <a class="c-nav__link" href="{{ route('register') }}">会員登録</a>
                                    </li>
                                @endif
                            @else
                                <li class="c-nav__item u-fwb">ようこそ、{{ Auth::user()->name }}さん</li>
                                <li class="c-nav__item">
                                    <a
                                        class="c-nav__link"
                                        href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                    >ログアウト</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </li>
                            @endguest
                        </ul>
                    </nav>
                </div>
            </div>
        </header>
        <main class="l-main">
            <div class="l-container">
                <div class="p-section">
                    <div class="p-section__inner">
                        <div class="p-section__head">{{ $year }}年{{ $month }}月 Ranking</div>
                        <ol class="p-section__lists">
                            @foreach ( $monthly_data as $data )
                                <li class="p-section__list">{{ $data->name }}さん {{ $data->distances }}km</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @component('components.calendar', [
                    'auth_id'     => $auth_id,
                    'day_of_week' => $day_of_week,
                    'calendar'    => $calendar,
                    'today'       => $today,
                ])
                @endcomponent
            </div>
        </main>
    </div>
</body>
</html>