<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public function books()
    {
        return $this->belongsToMany('App\Book')->withTimestamps();
    }

    public static function getForCheckboxes()
    {
        $tags = self::orderBy('name')->get();

        $tagsForCheckboxes = [];

        foreach ($tags as $tag) {
            $tagsForCheckboxes[$tag['id']] = $tag->name;
        }

        return $tagsForCheckboxes;
    }
}
