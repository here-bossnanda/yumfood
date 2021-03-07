<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $guarded = [];
    public function vendors()
    {
        return $this->morphedByMany('App\Vendor', 'taggable');
    }
}
