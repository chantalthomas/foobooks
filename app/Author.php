<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    public function books() {
        return $this->hasMany('App\Book');
    }

    public function getFullName()
    {
        return $this->first_name. ' ' .$this->last_name;
    }

    #use the self keyword when using static methods
    public static function getForDropdown()
    {
        return self::orderBy('last_name')->select(['id','first_name', 'last_name'])->get();
    }
}
