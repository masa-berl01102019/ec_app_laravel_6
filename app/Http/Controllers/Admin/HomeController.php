<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    // 上記のようにHomeController.phpのconstructメソッドでmiddleware(ミドルウェア)でauthを設定することで、
    //　HomeControllerを経由して行われる処理はすべて認証によるアクセスの制限が行われる。

    public function index()
    {
        return view('admin.home');
    }
}
