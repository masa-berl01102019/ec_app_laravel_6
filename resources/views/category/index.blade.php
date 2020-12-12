@extends('layouts.user.app')

@section('css')

@endsection

@section('content')
    {{--  user.layout.appで読み込んでる関数と同じ内容で別の名前で使ってるので修正必要  --}}
    @php
        function createQueryStringTwo ($array, $arr = null) {
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
    {{-- パンくずリスト --}}
    <div class="row">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('home')}}">HOME</a></li>
                @if($category_id)
                    @for($i = 0; $i < count($category_id) ; $i++)
                        @if($i == 0)
{{--                    <li class="breadcrumb-item"><a href="{{ route('category', ['gender' => $gender, 'depth_1' => $category_id[0] ]) }}">{{ $gender }}</a></li>--}}
                        <li class="breadcrumb-item"><a href="/category/{{$gender}}?{{ createQueryStringTwo(['gc' => $category_id[0]], ['mc', 'sc']) }} ">{{ $gender }}</a></li>
                        @endif
                        @if($i == 1)
{{--                    <li class="breadcrumb-item"><a href="{{ route('category', ['gender' => $gender, 'main_category' => $main_category, 'depth_1' => $category_id[0], 'depth_2' => $category_id[1] ]) }}">{{ $main_category }}</a></li>--}}
                        <li class="breadcrumb-item"><a href="/category/{{$gender}}/{{$main_category}}?{{ createQueryStringTwo(['gc' => $category_id[0], 'mc' => $category_id[1]], ['sc']) }} ">{{ $main_category }}</a></li>
                        @endif
                        @if($i == 2)
{{--                    <li class="breadcrumb-item"><a href="/category/{{$gender}}/?"{{ route('category', ['gender' => $gender, 'main_category' => $main_category, 'sub_category' => $sub_category, 'depth_1' => $category_id[0], 'depth_2' => $category_id[1], 'depth_3' => $category_id[2] ]) }}">{{ $sub_category }}</a></li>--}}
                        <li class="breadcrumb-item"><a href="/category/{{$gender}}/{{$main_category}}/{{$sub_category}}?{{ createQueryStringTwo(['gc' => $category_id[0], 'mc' => $category_id[1], 'sc' => $category_id[2]]) }}">{{ $sub_category }}</a></li>
                        @endif
                    @endfor
                @endif
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
