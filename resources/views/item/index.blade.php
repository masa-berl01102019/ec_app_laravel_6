@extends('layouts.user.app')

@section('content')
    <div class="container">
        <div class="contents row">
            @foreach($items as $item)
                @php
                    foreach($item->imgs as $img) {
                        if($img->img_category == 0) {
                            $main_img = $img->file_name;
                        }
                    }
                @endphp
                <div class="card col-sm-6 col-md-4 col-lg-3" style="width: 18rem;">
                    <a href="item/{{$item->id}}">
                        <img class="bd-placeholder-img card-img-top" src="{{ asset('/assets/img/item_main_pic/' . $main_img) }}" alt="test_img" width="150" height="200">
                    </a>
                    <div class="card-body">
                        <p class="card-text">{{ $item->item_name }}</p>
                        <p class="card-text">{{ $item->season }}</p>
                        <p class="card-text">¥{{ $item->price }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
