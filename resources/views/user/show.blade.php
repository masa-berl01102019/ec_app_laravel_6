@extends('layouts.user.app')

@section('content')
    @php
        $gender;
        if(isset($user->gender)) {
            if($user->gender == 0) {
                $gender = '男性';
            } elseif($user->gender == 1){
                $gender = '女性';
            } elseif($user->gender == 2){
                $gender = 'どちらでもない';
            } else {
                $gender = '無回答';
            }
        } else {
            $gender = '';
        }
    @endphp
    <div class="container" style="margin-top: 7%">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <table class="table ">
                    <thead>
                        <tr style="background-color: #3490dc; color: #fff;"><th scope="col" colspan="2">お客様情報</th></tr>
                    </thead>
                    <tbody style="background-color: #fff;">
                        <tr><th scope="row">お名前</th><td>{{ !empty($user->user_last_name)? $user->user_last_name: '' }} {{ !empty($user->user_first_name)? $user->user_first_name: '' }}</td></tr>
                        <tr><th scope="row">フリガナ</th><td>{{ !empty($user->user_last_name_kana)? $user->user_last_name_kana: '' }} {{ !empty($user->user_first_name_kana)? $user->user_first_name_kana: '' }}</td></tr>
                        <tr><th scope="row">性別</th><td>{{ $gender }}</td></tr>
                        <tr><th scope="row">生年月日</th><td>{{ !empty($user->birthday)? date('Y年m月d日', strtotime($user->birthday)) : '' }}</td></tr>
                        <tr><th scope="row">電話番号</th><td>{{ !empty($user->tel)? $user->tel: '' }}</td></tr>
                        <tr><th scope="row">メールアドレス</th><td>{{ !empty($user->email)? $user->email: '' }}</td></tr>
                        <tr><th scope="row">パスワード</th><td>＊＊＊＊＊＊＊＊</td></tr>
                        <tr><th scope="row">郵便番号</th><td>〒{{ !empty($user->post_code)? $user->post_code: '' }}</td></tr>
                        <tr>
                            <th scope="row">住所</th>
                            <td>
                                {{ !empty($user->prefecture)? $user->prefecture: '' }}
                                {{ !empty($user->municipality)? $user->municipality: '' }}
                                {{ !empty($user->street_name)? $user->street_name: '' }}
                                {{ !empty($user->street_number)? $user->street_number: '' }}
                                {{ !empty($user->building)? $user->building: '' }}
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="row mt-5 justify-content-center">
                    <a href="{{route('user.my_page')}}" class="btn btn-outline-dark btn-lg mr-3" role="button">マイページに戻る</a>
                    <a href="{{route('user.edit')}}" class="btn btn-danger btn-lg" role="button" aria-pressed="true">お客様情報の変更</a>
                </div>
            </div>
        </div>
    </div>
@endsection
