<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $guarded = [];

    public const VALIDATION_RULES = [
        'name' => 'required|string|min:3|max:128',
        'logo' => 'string|url'
    ];

    public function tags()
    {
        return $this->morphToMany('App\Tag', 'taggable');
    }
}
