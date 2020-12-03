<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Description extends Model
{
    public function item() {
        return $this->belongsTo('App\Models\Item');
    }
}
