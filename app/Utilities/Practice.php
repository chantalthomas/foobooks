<?php
/**
 * Created by PhpStorm.
 * User: chantalthomas
 * Date: 12/3/18
 * Time: 9:49 PM
 */

namespace App\Utilities;

use Illuminate\Support\Facades\Artisan;

class Practice
{
    public static function resetDatabase()
    {
        dump('Clearing and re-seeding database');
        Artisan::call('migrate:fresh');
        Artisan::call('db:seed');
    }
}