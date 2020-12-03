@extends('layouts.user.app')

@section('content')
    <div class="container">
        <div class="row justify-content-md-center">
            <h1 class="col-12">{{ $item->item_name }}</h1>
            <div class="col-8">
                <div class="row">
                    @foreach($item->imgs as $img)
                        @if($img->img_category == 0)
                            <img class="col-12" src="{{ asset('/assets/img/item_main_pic/' . $img->file_name) }}" alt="test_img" height="600">
                        @elseif($img->img_category == 1)
                            <img class="col-4" src="{{ asset('/assets/img/item_thumbnail_pic/' . $img->file_name) }}" alt="test_img" height="200">
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="col-4">
                <h2 class="col-12">¥{{ $item->price }}<span style="font-size: 10px"> 税込</span></h2>
                <p class="col-12">{{ $item->season }}</p>
                @foreach($item->descriptions as $desc)
                    <p class="col-12">{{ $desc->title }}</p>
                    <p class="col-12">{{ $desc->body }}</p>
                @endforeach
                <div class="row justify-content-md-center">
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
                <button type="button" class="btn btn-danger">
                    <a class="col-12" href="{{url('/')}}">カートに入れる</a>
                </button>
            </div>
        </div>

        <div class="row justify-content-md-center">
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
