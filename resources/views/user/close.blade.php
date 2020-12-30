@extends('layouts.user.app')

@section('content')
    <div class="container" style="margin-top: 7%">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="row justify-content-center">
                    <h3>退会ページ</h3>
                </div>
                <div class="row justify-content-center mt-3">
                    <p>退会されると購入履歴等が消去されますがよろしいですか？</p>
                </div>
                @if ($errors->first('delete_flg'))
                    <div class="alert alert-danger">
                        {{ $errors->first('delete_flg') }}
                    </div>
                @endif
                <form action="{{ route('user.delete', ['id' => $user->id]) }}" method="post">
                    @csrf
                    <input type="hidden" name="delete_flg" value='1'>
                    <div class="mt-5 mb-5" style="width:42%; margin: 0 auto;">
                        <a href="{{route('user.my_page')}}" class="btn  btn-outline-dark" role="button">マイページに戻る</a>
                        <button type="submit" class="btn btn-danger ">退会する</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
