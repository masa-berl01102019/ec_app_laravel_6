@extends('layouts.user.app')

@section('css')
    .pagination {
        justify-content: center;
    }
@endsection

@section('content')
    <div class="container">
        <div style="display: flex; flex-flow: wrap;">
            {{-- サイドバー --}}
            <div class="py-5" style="width: 21%; margin-right: 4%;">
                {{-- 検索機能 --}}
                <h2>SEARCH</h2>
                <form method="get" action="/search" class="form-inline">
                    <div class="form-group">
                        <input name="keyword" type="text" value="{{old('keyword')}}" class="form-control" placeholder="keyword">
                        <button type="submit" class="btn btn-primary"><img src="{{ asset('/assets/img/icon/search_icon.svg') }}" alt="search_icon"></button>
                    </div>
                </form>
                {{-- ソート機能 --}}
                <h2 class="mt-3">CONDITION</h2>
                <div >
                    <div class="dropdown">
                        <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            在庫の有無
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="{{url()->current()}}?{{http_build_query(array_merge(Request::query(), ['stock' => 0]),null, '&')}}">在庫なしも含む</a>
                            <a class="dropdown-item" href="{{url()->current()}}?{{http_build_query(array_merge(Request::query(), ['stock' => 1]),null, '&')}}">在庫ありのみ</a>
                        </div>
                    </div>
                </div>
                <div >
                    <div class="dropdown">
                        <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            新古順
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="{{url()->current()}}?{{http_build_query(array_merge(Request::query(), ['date' => 'desc']),null, '&')}}">新着順</a>
                            <a class="dropdown-item" href="{{url()->current()}}?{{http_build_query(array_merge(Request::query(), ['date' => 'asc']),null, '&')}}">古い順</a>
                        </div>
                    </div>
                </div>
                <div >
                    <div class="dropdown">
                        <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            価格順
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="{{url()->current()}}?{{http_build_query(array_merge(Request::query(), ['price' => 'desc']),null, '&')}}">価格が高い順</a>
                            <a class="dropdown-item" href="{{url()->current()}}?{{http_build_query(array_merge(Request::query(), ['price' => 'asc']),null, '&')}}">価格が安い順</a>
                        </div>
                    </div>
                </div>
                {{-- カテゴリ検索機能 --}}
                <h2 class="mt-3">CATEGORY</h2>
                <nav>
                    <ul class="nav nav-sidebar flex-column">
                        @foreach($categories as $category)
                            @if($category->id == 1 || $category->id == 2)
                                <li class="depth1 nav-item">
                                    <a href="/category/{{$category->category_name}}?{{ http_build_query(array_merge(Request::query(), ['gc' => $category->id, 'mc' => null, 'sc' => null, 'keyword' => null]),null, '&') }}" class="nav-link">{{ $category->category_name }}</a>
                                    @if(!$category->children->isEmpty())
                                        {{--                                empty()は引数が配列ならＯＫだけれど、Collectionのオブジェクトなら空を判断できないのでlaravelのisEmpty()関数で調べる--}}
                                        <ul style="list-style: none; padding: 0;">
                                            @foreach($category->children as $depth2)
                                                <li class="depth2 nav-item">
                                                    <a href="/category/{{$category->category_name}}/{{$depth2->category_name}}?{{ http_build_query(array_merge(Request::query(), ['gc' => $category->id, 'mc' => $depth2->id,  'sc' => null,  'keyword' => null]),null, '&') }}" class="nav-link">{{ $depth2->category_name }}</a>
                                                    @if(!$depth2->grandChildren->isEmpty())
                                                        <ul class="hidden" style="list-style: none; padding: 0;">
                                                            @foreach($depth2->grandChildren as $depth3)
                                                                <li class="nav-item">
                                                                    <a href="/category/{{$category->category_name}}/{{$depth2->category_name}}/{{$depth3->category_name}}?{{ http_build_query(array_merge(Request::query(), ['gc' => $category->id, 'mc' => $depth2->id, 'sc' => $depth3->id,  'keyword' => null]),null, '&') }}" class="nav-link">{{ $depth3->category_name }}</a>
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
            {{-- メイン --}}
            <div class="py-5" style="width: 75%; height: 900px; display: flex; justify-content: flex-start; flex-flow: wrap; align-items: flex-start; align-content: start;">
                @forelse ($items as $item)
                    <div class="card col-3">
                        <a href="{{route('detail',[$item->id])}}">
                            <img class="bd-placeholder-img card-img-top" src="{{ asset('/assets/img/item_main_pic/' . $item->file_name) }}" alt="test_img" width="150" height="200">
                        </a>
                        <div class="card-body">
                            <p class="card-text">{{ $item->item_name }}</p>
                            <p class="card-text">{{ date('Y年m月d日', strtotime($item->created_at)) }}</p>
                            <p class="card-text">¥{{ $item->price }}</p>
                        </div>
                    </div>
                @empty
                    <p>該当の商品が見つかりません。</p>
                @endforelse
                <div class="mt-4 col-12">
                    {{ $items->appends(request()->query())->links() }}
                    {{--             ページネーションのセット クエリ文字列を保持してページネーションをかける場合はappends()内で連想配列を渡してあげればいい--}}
                </div>
            </div>
        </div>
    </div>
@endsection
