<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:user')->except('logout');
    }

    // Guardの認証方法を指定
    protected function guard()
    {
        return Auth::guard('user');
    }

    // ログイン画面
    public function showLoginForm()
    {
        return view('user.auth.login');
    }

    // ログアウト処理
    public function logout()
    {
        Auth::guard('user')->logout();

        return redirect('/');
    }

    // ログインの条件を追加
    protected function credentials(Request $request)
    {
        // emailカラムとpasswordカラム（laravelのデフォルト）が入ってくる
        $conditions = $request->only($this->username(), 'password');

        // 追加条件を$conditionsの配列に追加
        $conditions_custom = array_merge(
            $conditions,
            ['delete_flg' => '0']
        );
        // 倫理削除されたユーザーがログインできないようにdelete_flgが０でないものをはじくよう条件追加

        return $conditions_custom;
        // 参考URL: https://i-purple-u.com/2020/03/11/laravel-auth-2/
    }
}
