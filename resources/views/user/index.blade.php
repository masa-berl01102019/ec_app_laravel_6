@extends('layouts.user.app')

@section('content')
    <div class="container">
        <div style="display: flex; flex-flow: wrap;">
            {{-- サイドバー --}}
            <div class="py-5" style="width: 21%; margin-right: 4%;">
            {{-- main_page --}}
                <h3>会員メニュー</h3>
                <nav class="mt-3">
                    <ul class="nav nav-sidebar flex-column">
                        <li class="nav-item">
                            <a href="{{route('user.profile')}}" class="nav-link">お客様情報確認</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('user.edit')}}" class="nav-link">お客様情報編集</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('user.close')}}" class="nav-link">退会の手続き</a>
                        </li>
                    </ul>
                </nav>
            </div>
            {{-- メイン --}}
            <div class="py-5" style="width: 75%; height: 900px; display: flex; justify-content: flex-start; flex-flow: wrap; align-items: flex-start; align-content: start;">
                <h1>TOP PAGE</h1>
            </div>
        </div>
    </div>
@endsection
