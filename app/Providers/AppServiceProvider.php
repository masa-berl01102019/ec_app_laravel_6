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
    // php artisan config:cache でboot()も読み込まれるので注意
    public function boot()
    {
        // アプリケーションの全ビューで使用するデータを共有したい場合は下記のように
        // View::composer('*', function($view) {　処理　〜　$view->with([key => value]); }); の形で変数を渡すことができる
        // HTTPリクエストを受けてHTMLファイルをレンスポンスとして返す前に実行される
        // 配列で複数のviewを指定出来る
        View::composer(['item.index', 'search.index', 'category.index'], function($view) {

            // サイドバーのカテゴリ一覧
            $categories = Category::select('id', 'category_name', 'parent_id')->where('parent_id', 0)->where('delete_flg', 0)
                ->with([
                    'children' => function ($query) {
                        $query->select('id', 'category_name', 'parent_id')->where('delete_flg', 0); // 0: 未削除
                    },
                    'children.grandChildren' => function ($query) { // childrenの下に紐づける形でリレーション追加
                        $query->select('id', 'category_name', 'parent_id')->where('delete_flg', 0); // 0: 未削除
                    }
                ])->get();

            $view->with([
                'categories' => $categories,
            ]);
        });

    }
}
