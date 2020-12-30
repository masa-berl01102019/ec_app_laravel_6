<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $search_items;

    // 共通処理をまとめる
    public function __construct () {

        // クエリを生成
        $this->search_items = Category::query();

        // item/category/search コントローラーで必要なテーブルを結合
        $this->search_items->select('items.id', 'item_name', 'price', 'season', 'file_name', 'items.created_at')
        ->join('category_item','category_item.category_id','=','categories.id')
        ->join('items','items.id','=','category_item.item_id')
        ->join('imgs','imgs.item_id','=','items.id')
        ->join('stocks','stocks.item_id','=','items.id')
        ->where('items.delete_flg', 0) // 0: 未削除
        ->where('img_category', 0)
        ->distinct('items.id');


    }
}
