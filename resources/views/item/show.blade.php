@extends('layouts.user.app')

@section('content')
    <div class="container">
        <div class="row justify-content-md-center">
            <h1 class="col-12">{{ $item->item_name }}</h1>
            <div class="col-6">
                <div class="row">
                    @foreach($item->imgs as $img)
                        @if($img->img_category == 0)
                            <img class="col-12" src="{{ asset('/assets/img/item_main_pic/' . $img->file_name) }}" alt="test_img" height="430">
                        @elseif($img->img_category == 1)
                            <img class="col-4" src="{{ asset('/assets/img/item_thumbnail_pic/' . $img->file_name) }}" alt="test_img" height="200">
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="mt-3 col-6">
                <h2 class="col-12">¥{{ $item->price }}<span style="font-size: 10px"> 税込</span>
                    <button type="button" class="btn btn-outline-primary"><a class="col-12" href="{{url('/')}}">カートに入れる</a></button>
                </h2>

                <p class="col-12">{{ $item->season }}</p>
                @foreach($item->descriptions as $desc)
                    <p style="font-weight: bold; font-size: 12px" class="col-11">{{ $desc->title }}</p>
                    <p style="font-size: 12px" class="col-11">{{ $desc->body }}</p>
                @endforeach
                <div class="row col-12 justify-content-md-center">
                    <table class="table table-bordered table-sm">
                        <thead>
                        <tr>
                            @foreach($stock[0] as $key => $value)
                                <th scope="row">{{$key}}</th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody>
                        @for($i = 0; $i < count($stock); $i++)
                            <tr>
                                @foreach($stock[$i] as $value)
                                    <td>{{ $value }}</td>
                                @endforeach
                            </tr>
                        @endfor
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="row col-12 mt-3 justify-content-md-center">
            <table class="table table-bordered table-sm">
                <thead>
                <tr>
                    @foreach($size[0] as $key => $value)
                        @if($value === null)
                            @continue
                        @endif
                        <th scope="row">{{$key}}</th>
                    @endforeach
                </tr>
                </thead>
                <tbody>
                @for($i = 0; $i < count($size); $i++)
                    <tr>
                        @foreach($size[$i] as $value)
                            @if($value === null)
                              @continue
                            @endif
                            <td>{{ $value }}</td>
                        @endforeach
                    </tr>
                @endfor
                </tbody>
            </table>
        </div>
    </div>
@endsection
