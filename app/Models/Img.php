<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Img extends Model
{
    public function item() {
        return $this->belongsTo('App\Models\Item');
    }
}
