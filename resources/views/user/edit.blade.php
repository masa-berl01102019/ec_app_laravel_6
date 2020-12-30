@extends('layouts.user.app')

@section('content')
    @php
        $gender = [0 => '男性', 1 =>  '女性', 2 => 'どちらでもない', 3 => '無回答'];
    @endphp
    <div class="container" style="margin-top: 7%">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="row justify-content-center">
                    <h3>お客様情報の編集</h3>
                </div>
                <form action="{{ route('user.update', ['id' => $user->id])}}" method="post">
                    @csrf
                    <div class="mb-2">お名前</div>
                    <div class="form-group">
                        <label>姓<input type="text" name="user_last_name" class="form-control @error('user_last_name') is-invalid @enderror" value="{{ !empty($user->user_last_name)? $user->user_last_name: '' }}" placeholder="例) 山田"></label>
                        <label>名<input type="text" name="user_first_name" class="form-control @error('user_first_name') is-invalid @enderror" value="{{ !empty($user->user_first_name)? $user->user_first_name: '' }}" placeholder="例) 太郎"></label>
                        @error('user_last_name')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        @error('user_first_name')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>セイ<input type="text" name="user_last_name_kana" class="form-control @error('user_last_name_kana') is-invalid @enderror" pattern="[ァ-ヴー]+" value="{{ !empty($user->user_last_name_kana)? $user->user_last_name_kana: '' }}" placeholder="例) ヤマダ"></label>
                        <label>メイ<input type="text" name="user_first_name_kana" class="form-control @error('user_first_name_kana') is-invalid @enderror" pattern="[ァ-ヴー]+" value="{{ !empty($user->user_first_name_kana)? $user->user_first_name_kana: '' }}" placeholder="例) タロウ"></label>
                        @error('user_last_name_kana')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        @error('user_first_name_kana')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div class="mb-2">性別</div>
                        @foreach($gender as $key => $value)
                            @if(isset($user->gender) && $key == $user->gender)
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">{{$value}}<input class="form-check-input @error('gender') is-invalid @enderror" type="radio" name="gender" value="{{$key}}" checked></label>
                                </div>
                            @else
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">{{$value}}<input class="form-check-input @error('gender') is-invalid @enderror" type="radio" name="gender" value="{{$key}}" ></label>
                                </div>
                            @endif
                        @endforeach
                        @error('gender')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div class="mb-2">生年月日</div>
                        <label class="col-form-label">年<input type="number" name="birthday[]" class="form-control @error('birthday') is-invalid @enderror" value="{{ !empty($user->birthday)? date('Y', strtotime($user->birthday)) : '' }}" placeholder="例) 1986"></label>
                        <label>月<input type="number" name="birthday[]" class="form-control" value="{{ !empty($user->birthday)? date('m', strtotime($user->birthday)) : '' }}" placeholder="例) 5"></label>
                        <label>日<input type="number" name="birthday[]" class="form-control" value="{{ !empty($user->birthday)? date('d', strtotime($user->birthday)) : '' }}" placeholder="例) 23"></label>
                        @error('birthday')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="tel">電話番号</label>
                        <input type="tel" id="tel" name="tel" class="form-control @error('tel') is-invalid @enderror" pattern="\d{2,4}-\d{3,4}-\d{3,4}" value="{{ !empty($user->tel)? $user->tel: '' }}" placeholder="例) 080-1234-1234">
                        @error('tel')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email"><span style="background:red; color:#fff; padding: 2px;">必須</span>　メールアドレス</label>
                        <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ !empty($user->email)? $user->email: '' }}" required placeholder="例) test@gmail.com">
                        @error('email')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password"><span style="background:red; color:#fff; padding: 2px;">必須</span>　現在のパスワード (半角英数字混合)</label>
                        <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                        @error('password')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="new_password">新しいパスワード (半角英数字混合)</label>
                        <input type="password" id="new_password" name="new_password" class="form-control @error('new_password') is-invalid @enderror">
                        @error('new_password')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="post_code">郵便番号</label>
                        <input type="text" id="post_code" name="post_code" class="form-control @error('post_code') is-invalid @enderror" pattern="\d{3}-\d{4}" value="{{ !empty($user->post_code)? $user->post_code: '' }}" placeholder="例) 123-4567">
                        @error('post_code')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="prefecture">都道府県</label>
                        <input type="text" id="prefecture" name="prefecture" class="form-control @error('prefecture') is-invalid @enderror" value="{{ !empty($user->prefecture)? $user->prefecture: '' }}" placeholder="例) 〇〇県">
                        @error('prefecture')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="municipality">市区町村</label>
                        <input type="text" id="municipality" name="municipality" class="form-control @error('municipality') is-invalid @enderror" value="{{ !empty($user->municipality)? $user->municipality: '' }}" placeholder="例) 〇〇市〇〇区">
                        @error('municipality')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="street_name">町名</label>
                        <input type="text" id="street_name" name="street_name" class="form-control @error('street_name') is-invalid @enderror" value="{{ !empty($user->street_name)? $user->street_name: '' }}" placeholder="例) 〇〇町">
                        @error('street_name')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="street_number">丁目番地</label>
                        <input type="text" id="street_number" name="street_number" class="form-control @error('street_number') is-invalid @enderror" value="{{ !empty($user->street_number)? $user->street_number: '' }}" placeholder="例) 〇〇番地〇〇丁目〇〇号">
                        @error('street_number')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="building">建物名</label>
                        <input type="text" id="building" name="building" class="form-control @error('building') is-invalid @enderror" value="{{ !empty($user->building)? $user->building: '' }}" placeholder="例) 〇〇アパート〇〇号室">
                        @error('building')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mt-5 mb-5" style="width:42%; margin: 0 auto;">
                        <a href="{{route('user.my_page')}}" class="btn  btn-outline-dark" role="button">マイページに戻る</a>
                        <button type="submit" class="btn btn-danger ">変更内容を更新する</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
