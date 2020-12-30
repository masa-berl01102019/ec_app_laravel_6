<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', 'ItemController@index')->name('home');
Route::get('/item/{id}', 'ItemController@show')->name('detail');
Route::get('/search', 'SearchController@index')->name('search');
Route::get('/category/{gender}/{main_category?}/{sub_category?}', 'CategoryController@index')->name('category');
// ルートパラメータを渡す時は？をつければパラメータが挿入されなくても大丈夫



// Userに対してのルーティング
Route::namespace('User')->prefix('user')->name('user.')->group(function() {
    // namespace: 今回フォルダの階層がControllers/User/HomeController.phpなのでcontroller@actionを指定する際に名前スペースの指定が必要になる
    // 上記のようにグループで囲ってルーティングする際にnamespace('User')と事前に指定することでUser\HomeController@actionといった形で呼び出さなくてよくなる
    // prefix: URLの頭につける文 ‘prefix’ => ‘admin’ なら admin/login などになる
    //　上記のようにグループで囲ってルーティングする際にname('user.')と事前に指定することで
    //　グループ内で名前付きルーティングを仮にname('login')と設定してもルーティング名は’user.login’となる

    // ログイン認証関連の設定
    Auth::routes([
        'register' => true,
        'reset' => false,
        'verify' => false
    ]);
    // 認証機能のルーティングはAuth::routes();の一文で、一括して機能する
    // 上記のように連想配列の引数を渡してあげることで認証の各機能に対して、ON・OFFの切り替えを行うことができる
    // trueがON,falseがOFF
    // register : ユーザー登録へのルーティング
    // reset : アカウントリセットへのルーティング
    // verify : メールアドレス確認へのルーティング

    // ログイン認証後
    Route::middleware('auth:user')->group(function() {
        // 上記のようにRouteファサードに対してmiddleware('auth:user')で対象とするGuardを指定してルーティングを行える
        // グループ内で事前に設定されているので下記はurlが’/user/login’でgetでアクセスされたらUserフォルダ直下のHomeControllerのindexメソッドを呼び出し、名前付きルーティングは'user.my_page'となる
        Route::get('/my-account', 'HomeController@index')->name('my_page'); // アカウントTOP画面
        Route::get('/my-account/show', 'HomeController@show')->name('profile'); // アカウント詳細画面
        Route::get('/my-account/edit','HomeController@edit')->name('edit'); // アカウント編集画面
        Route::post('/my-account/{id}/update','HomeController@update')->where('id','[0-9]+')->name('update'); // アカウント更新処理
        Route::get('/my-account/close','HomeController@close')->name('close'); // アカウント退会画面
        Route::post('/my-account/{id}/delete','HomeController@destroy')->where('id','[0-9]+')->name('delete'); // アカウント削除処理

    });

});

// Adminに対してのルーティング
Route::namespace('Admin')->prefix('admin')->name('admin.')->group(function() {

    // ログイン認証関連の設定
    Auth::routes([
        'register' => true,
        'reset' => false,
        'verify' => false
    ]);

    // ログイン認証後
    Route::middleware('auth:admin')->group(function() {
        // TOPページにアクセス
        Route::get('/home', 'HomeController@index')->name('home');
    });

});
