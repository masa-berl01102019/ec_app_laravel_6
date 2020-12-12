<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>
    {{--   サイドバー用CSS     --}}
        .hidden {
            display: none;
            transition: 1s;
        }
        .depth1 > a {
            background: lightblue;
            color: white !important;
        }
        .depth2 {
            border: 1px solid #ddd;
        }
        .depth2  ul > li {
            background: #94bdc142;
            border: 1px solid #ddd;
        }
        .depth2:hover ul {
            display: block;
        }

    </style>

    @yield('css')
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto"></ul>

                    <ul class="navbar-nav ml-auto">
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('user.login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('user.register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('user.register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ url('user.logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('user.logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container">
        {{-- 共通で使う関数をまとめる場所を探す　categoryのパンくずリストで同じ関数を別名で使っているので保守性にかける --}}
            @php
                function createQueryString ($array, $arr = null) {
                    $current_query_string = request()->query();

                    if($arr) {
                        for($i = 0; $i < count($arr); $i++) {
                            if (array_key_exists($arr[$i], $current_query_string)){
                                unset($current_query_string[$arr[$i]]);
                            }
                        }
                    }
                    $params = http_build_query(array_merge($current_query_string, $array),null, '&');
                    return $params;
                }
            @endphp
            <div class="row">
                {{-- userのログイン画面等でサイドーを表示しないようにurlで出し分け --}}
                @if(!Request::is('user/*'))
                {{-- サイドバー --}}
                <div class="col-3 py-5">
                    {{-- 検索機能 --}}
                    <h2>SEARCH</h2>
                    <form method="get" action="/search" class="form-inline">
                        <div class="form-group">
                            <input name="keyword" type="text" value="{{old('keyword')}}" class="form-control" placeholder="keyword">
                            <button type="submit" class="btn btn-primary"><img src="{{ asset('/assets/img/icon/search.png') }}" alt="search_icon"></button>
                        </div>
                        @if($errors->has('keyword'))
                            <span class="error">{{ $errors->first('keyword') }}</span>
                        @endif
                    </form>

                    {{-- ソート機能 --}}
                    <h2 class="mt-3">CONDITION</h2>
                    <div class="row">
                        <div class="dropdown">
                            <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                在庫の有無
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="{{url()->current()}}?{{ createQueryString(['stock' => 0]) }}" >在庫なしも含む</a>
                                <a class="dropdown-item" href="{{url()->current()}}?{{ createQueryString(['stock' => 1]) }}">在庫ありのみ</a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="dropdown">
                            <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                新古順
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="{{url()->current()}}?{{ createQueryString(['date' => 'desc']) }}">新着順</a>
                                <a class="dropdown-item" href="{{url()->current()}}?{{ createQueryString(['date' => 'asc']) }}">古い順</a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="dropdown">
                            <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                価格順
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="{{url()->current()}}?{{ createQueryString(['price' => 'desc']) }}">価格が高い順</a>
                                <a class="dropdown-item" href="{{url()->current()}}?{{ createQueryString(['price' => 'asc']) }}">価格が安い順</a>
                            </div>
                        </div>
                    </div>

                    {{-- カテゴリ検索機能 --}}
                    <h2>CATEGORY</h2>
                    <nav class="mt-3">
                        <ul class="nav nav-sidebar flex-column">
                            @foreach($categories as $category)
                                @if($category->id == 1 || $category->id == 2)
                                <li class="depth1 nav-item">
{{--                                <a href="{{ route('category', ['gender' => $category->category_name, 'depth_1' => $category->id]) }}" class="nav-link">{{$category->category_name}}</a>--}}
                                    <a href="/category/{{$category->category_name}}?{{ createQueryString(['gc' => $category->id], ['mc', 'sc', 'keyword']) }}" class="nav-link">{{ $category->category_name }}</a>
                                    @if(!$category->children->isEmpty())
{{--                                empty()は引数が配列ならＯＫだけれど、Collectionのオブジェクトなら空を判断できないのでlaravelのisEmpty()関数で調べる--}}
                                    <ul style="list-style: none; padding: 0;">
                                        @foreach($category->children as $depth2)
                                        <li class="depth2 nav-item">
{{--                                        <a href="{{ route('category', ['gender' => $category->category_name,'main_category' => $depth2->category_name, 'depth_1' => $category->id, 'depth_2' => $depth2->id]) }}" class="nav-link">{{$depth2->category_name}}</a>--}}
                                            <a href="/category/{{$category->category_name}}/{{$depth2->category_name}}?{{ createQueryString(['gc' => $category->id, 'mc' => $depth2->id], ['sc', 'keyword']) }}" class="nav-link">{{ $depth2->category_name }}</a>
                                            @if(!$depth2->children->isEmpty())
                                            <ul class="hidden" style="list-style: none; padding: 0;">
                                                @foreach($depth2->children as $depth3)
                                                <li class="nav-item">
{{--                                                <a href="{{ route('category', ['gender' => $category->category_name, 'main_category' => $depth2->category_name, 'sub_category' => $depth3->category_name, 'depth_1' => $category->id, 'depth_2' => $depth2->id, 'depth_3' => $depth3->id]) }}" class="nav-link">{{$depth3->category_name}}</a>--}}
                                                    <a href="/category/{{$category->category_name}}/{{$depth2->category_name}}/{{$depth3->category_name}}?{{ createQueryString(['gc' => $category->id, 'mc' => $depth2->id, 'sc' => $depth3->id], ['keyword']) }}" class="nav-link">{{ $depth3->category_name }}</a>
                                                </li>
                                                @endforeach
                                            </ul>
                                            @endif
                                        </li>
                                        @endforeach
                                    </ul>
                                    @endif
                                </li>
                                @endif
                            @endforeach
                        </ul>
                    </nav>
                </div>
                @endif
                {{-- メイン --}}
                <div class="col-9 py-5">
                    @yield('content')
                </div>
            </div>
            {{-- login用コンテンツ --}}
            @yield('auth')
        </div>
    </div>

</body>
</html>
