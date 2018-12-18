<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    public function author () {
        return $this->belongsTo('App\Author');
    }

    public function tags () {
        return $this->belongsToMany('App\Tag')->withTimestamps();
    }
}
