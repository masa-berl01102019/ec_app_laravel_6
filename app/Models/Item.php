<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    public function sizes() {
        return $this->hasMany('App\Models\Size');
    }

    public function stocks() {
        return $this->hasMany('App\Models\Stock');
    }

    public function categories() {
        return $this->belongsToMany('App\Models\Category');
    }

    public function imgs() {
        return $this->hasMany('App\Models\Img');
    }

    public function descriptions() {
        return $this->hasMany('App\Models\Description');
    }
}
