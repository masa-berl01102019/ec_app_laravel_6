<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    public function item() {
        return $this->belongsTo('App\Models\Item');
    }
}
