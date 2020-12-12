@extends('layouts.user.app')

@section('css')

@endsection

@section('content')
    {{-- パンくずリスト --}}
    <div class="row">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('home')}}">HOME</a></li>
                <li class="breadcrumb-item">検索キーワード( {{$previous_keyword}} )</li>
            </ol>
        </nav>
    </div>

    {{-- メイン --}}
    <div class="row">
        @forelse ($items as $item)
            <div class="card col-sm-6 col-md-4 col-lg-3" style="width: 18rem;">
                <a href="{{route('detail',[$item->id])}}">
                    <img class="bd-placeholder-img card-img-top" src="{{ asset('/assets/img/item_main_pic/' . $item->file_name) }}" alt="test_img" width="150" height="200">
                </a>
                <div class="card-body">
                    <p class="card-text">{{ $item->item_name }}</p>
                    <p class="card-text">{{ $item->season }}</p>
                    <p class="card-text">¥{{ $item->price }}</p>
                </div>
            </div>
        @empty
            <p>該当の商品が見つかりません。</p>
        @endforelse
    </div>
    <div class="mt-4 row justify-content-center">
        {{ $items->appends(request()->query())->links() }}
        {{-- ページネーションのセット クエリ文字列を保持してページネーションをかける場合はappends()内で連想配列を渡してあげればいい --}}
    </div>
@endsection
