<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function items() {
        return $this->belongsToMany('App\Models\Item');
    }

    // 階層構造用にリレーション
    public function parent() {
        return $this->belongsTo('App\Models\Category', "parent_id", "id");
    }

    // 階層構造用にリレーション
    public function children() {
        return $this->hasMany('App\Models\Category', "parent_id", "id");
    }

    // 階層構造用にリレーション * SQLのパフォーマンスが悪かったので追加
    public function grandChildren() {
        return $this->hasMany('App\Models\Category', "parent_id", "id");
    }

}
