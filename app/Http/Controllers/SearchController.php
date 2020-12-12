<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    protected $search_items;

    // プロパティを宣言後にコンストラクタ内でそれぞれに値をセットして継承したコントローラがアクセスできるようにしている
    public function __construct()
    {
        parent::__construct(); // 親コンストラクタ(Controller.php)を呼び出し
    }

    public function index (Request $request) {
        // 検索し直すとソートが消える

        $keyword = $request->input('keyword');
        // 全角スペースを半角スペースに変換
        $keyword = mb_convert_kana($keyword, 's', 'UTF-8');
        // 前後のスペース削除（trimの対象半角スペースのみなので半角スペースに変換後行う）
        $keyword = trim($keyword);
        // 連続する半角スペースを半角スペースひとつに変換
        $keyword = preg_replace('/\s+/', ' ', $keyword);
        // 半角スペース区切りで配列に変換
        $keywords = explode(' ',$keyword);

        // テーブル結合してキーワード検索で渡ってきた値と部分一致するアイテムに絞りこみ
        $this->search_items->where(function ($query) use ($keywords) {
            foreach ($keywords as $keyword) { // 複数のkeywordを検索
                $query->orWhere('item_name', 'like', "%{$keyword}%");
            }
        });
        // 参考URL: https://blog.hiroyuki90.com/articles/laravel-where/#i-3

        // 在庫の有無で絞り込み
        if (!is_null($request->stock)) {
            $stock_sort = $request->stock == 1? true:false; // 1:在庫有りのみ　0:在庫無しも含む
            $this->search_items->when( $stock_sort, function ($query) {
                return $query->where('quantity_s', '>', 0) // trueの処理
                ->where('quantity_m', '>', 0)
                    ->where('quantity_l', '>', 0);
            }, function ($query) {
                return $query->where('quantity_s', '>=', 0) // falseの処理
                ->where('quantity_m', '>=', 0)
                    ->where('quantity_l', '>=', 0);
            });
        }

        // 価格順でソート
        if(!is_null($request->price)) {
            $price_sort = $request->price;
            $this->search_items->orderBy('price', $price_sort);
        }

        // 新古順でソート　＊価格順と新古順の両方でソートがかかった場合は価格順を優先して、同価格の時に新古順でソートされる仕組み
        if(!is_null($request->date)) {
            $date_sort = $request->date;
            $this->search_items->orderBy('items.created_at', $date_sort);
        }

        // コレクションを生成
        $items = $this->search_items->paginate(6);

        return view('search.index', ['items' => $items, 'previous_keyword' => $keyword]);
    }
}
