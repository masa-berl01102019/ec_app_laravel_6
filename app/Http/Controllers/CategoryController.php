<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class CategoryController extends Controller
{
    protected $search_items;

    // プロパティを宣言後にコンストラクタ内でそれぞれに値をセットして継承したコントローラがアクセスできるようにしている
    public function __construct()
    {
        parent::__construct(); // 親コンストラクタ(Controller.php)を呼び出し

    }

    public function index($gender, $main_category = null, $sub_category = null, Request $request)
    {
        // ルートパラメータは引数で受け取れる
        // クエリ文字列はweb.phpでルーティングを書く際に変数名を明記しなくてもよく、Request $requestで受け取れる
        // $request->ルートパラメータ or クエリ文字列で渡ってきた値が取れるので$変数は省略可能

        // itemとsortから渡って来る場合のみソートの設定が渡って来る

        // クエリ文字列で渡ってきたカテゴリIDのセット
        $id_list = [$request->gc, $request->mc, $request->sc];

        // カテゴリIDは 1 ~ かつ 入力値がなければnullが渡ってくるのでarray_filter()でnullを排除した配列を生成
        $category_id = array_filter($id_list);

        // カテゴリIDは連想配列で渡ってくるので最後に挿入された値をend()で取得
        $last_id = end($category_id);

        // テーブル結合してカテゴリ検索で渡ってきた詳細度の高いカテゴリIDを含むアイテムに絞りこみ
        $this->search_items->where('categories.id', $last_id);

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
        $items = $this->search_items->get();

        // 独自のページネーションを作成
        $itemsPaginate = new LengthAwarePaginator(
            $items->forPage($request->page, 5), // 現在のページのsliceした情報(現在のページ, 1ページあたりの件数)
            $items->count(), // 総件数
            5,
            null,
            ['path' => $request->url()]
        );
        // 通常のpaginate()はエロクエントモデルやクエリビルダには使えるが、コレクション型には使えないので独自のページネーションを作成する必要がある
        // 参考url: https://pgmemo.tokyo/data/archives/1278.html
        // 参考url: https://manablog.org/laravel-search-with-pagination/
        // 参考url: https://shishido.dev/laravel-paginator/


        return view('category.index',
            [
                'items' => $itemsPaginate,
                'category_id' => $category_id,
                'gender' => $gender,
                'main_category' => $main_category,
                'sub_category' =>$sub_category
            ]
        );

    }

}
