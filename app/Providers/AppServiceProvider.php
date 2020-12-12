<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // アプリケーションの全ビューで使用するデータを共有したい場合は下記のように
        // View::composer('*', function($view) {　処理　〜　$view->with([key => value]); }); の形で変数を渡すことができる
        // HTTPリクエストを受けてHTMLファイルをレンスポンスとして返す前に実行される
        View::composer('layouts.user.app', function($view) {

            // サイドバーのカテゴリ一覧
            $categories = Category::with(['children' => function ($query) {
                $query->where('delete_flg', 0); // 0: 未削除
            }])->get();

            $view->with([
                'categories' => $categories,
            ]);
        });

    }
}
