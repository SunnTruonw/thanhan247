<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Route;

/**
 *
 */
trait CheckLanguageTrait
{
    function checkRouteLanguage($slug, $data)
    {
        if ($slug != $data->slug) {
             $name=Route::currentRouteName();
             return redirect()->route($name, ['slug' => $data->slug]);
        }else{
            return false;
        }
    }
}
