<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{

    protected $search_items;

    // プロパティを宣言後にコンストラクタ内でそれぞれに値をセットして継承したコントローラがアクセスできるようにしている
    public function __construct()
    {
        parent::__construct(); // 親コンストラクタ(Controller.php)を呼び出し

    }

    public function index(Request $request)
    {
        // homeにアクセスするとソートの設定が消える　リダイレクト時にパラメータを変数で渡す必要有り

        // 在庫の有無でソート
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
        // paginate()に値をセットしてページネーションを作成
        // 参考URL: https://qiita.com/ryu19maki/items/cf35b1abd1814e722f14

        return view('item.index', ['items' => $items]);
    }

    public function show($id)
    {
        // リレーション
        $item = Item::select('items.id', 'item_name', 'price', 'season', 'made_in')->where('id', $id)->where('delete_flg', 0)->with([
            'sizes' => function ($query) {
                $query->select(['item_id','size', 'width', 'shoulder_width', 'raglan_sleeve_length', 'sleeve_length', 'length', 'waist', 'hip', 'rise', 'inseam', 'thigh_width', 'outseam', 'sk_length', 'hem_width', 'weight']);
                // FK('item_id')を渡さないと紐づかない
            },
            'imgs' => function ($query) {
                $query->select(['item_id', 'file_name', 'img_category']);
            },
            'descriptions' => function ($query) {
                $query->select(['item_id', 'title', 'body']);
            },
            'stocks' => function ($query) {
                $query->select(['item_id', 'color', 'quantity_s', 'quantity_m', 'quantity_l']);
            },
        ])->get();

        // サイズのデータ整形
        $size = [];
        for ($i = 0; $i < count($item[0]->sizes); $i++) {
            switch ($item[0]->sizes[$i]['size']) {
                case 0:
                    $item[0]->sizes[$i]['size'] = 'S';
                    break;
                case 1:
                    $item[0]->sizes[$i]['size'] = 'M';
                    break;
                case 2:
                    $item[0]->sizes[$i]['size'] = 'L';
                    break;
            }
            $size[$i] = [
                'サイズ' => $item[0]->sizes[$i]['size'],
                '身幅' => $item[0]->sizes[$i]['width'],
                '肩幅' => $item[0]->sizes[$i]['shoulder_width'],
                '裄丈' => $item[0]->sizes[$i]['raglan_sleeve_length'],
                '袖丈' => $item[0]->sizes[$i]['sleeve_length'],
                '着丈' => $item[0]->sizes[$i]['length'],
                'ウエスト' => $item[0]->sizes[$i]['waist'],
                'ヒップ' => $item[0]->sizes[$i]['hip'],
                '股上' => $item[0]->sizes[$i]['rise'],
                '股下' => $item[0]->sizes[$i]['inseam'],
                'もも幅' => $item[0]->sizes[$i]['thigh_width'],
                'パンツ総丈' => $item[0]->sizes[$i]['outseam'],
                'スカート丈' => $item[0]->sizes[$i]['sk_length'],
                '裾幅' => $item[0]->sizes[$i]['hem_width'],
                '重量' => $item[0]->sizes[$i]['weight']
            ];
        }

        // 在庫のデータ整形
        $stock = [];
        for($i = 0; $i < count($item[0]->stocks); $i++) {
            $stock[$i] = [
                'カラー' => $item[0]->stocks[$i]['color'],
                'Sサイズ在庫' => empty($item[0]->stocks[$i]['quantity_s']) || $item[0]->stocks[$i]['quantity_s'] < 0 ? '×' : '○',
                'Mサイズ在庫' => empty($item[0]->stocks[$i]['quantity_m']) || $item[0]->stocks[$i]['quantity_m'] < 0 ? '×' : '○',
                'Lサイズ在庫' => empty($item[0]->stocks[$i]['quantity_l']) || $item[0]->stocks[$i]['quantity_l'] < 0 ? '×' : '○'
                // empty() では-1以下の場合はfalse になるので条件を追加
            ];
        }

        return view('item.show',['item' => $item[0], 'size' => $size, 'stock' => $stock]);
    }

}
