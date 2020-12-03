<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::with('imgs')->latest()->get();
        return view('item.index')->with('items',$items);
    }

    public function show($id)
    {

        $item = Item::where('id', $id)->with([
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

//            $item->categories[1]->id == 3 // men's tops
//            $item->categories[1]->id == 4 // men's Jackets / Coats
//            $item->categories[1]->id == 7 // women's tops
//            $item->categories[1]->id == 8 // women's Jackets / Coats
//            $item->categories[1]->id == 5 // men's pants
//            $item->categories[1]->id == 9 // women's pants
//            $item->categories[1]->id == 11 // women's skirts
//            $item->categories[1]->id == 12 // women's one piece
}
