<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    //
    private $langConfig;
    private $langDefault;
    public function __construct()
    {
        $this->langConfig = config('languages.supported');
        $this->langDefault = config('languages.default');
    }
    public function index($language){

        if (! in_array($language, array_keys($this->langConfig))) {
            abort(400);
        }else{
            session(['language' => $language]);
        }
        return back();
     //   return redirect(makeLink('home'));
    }
}
