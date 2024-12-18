<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;


class LanguageController extends Controller
{
    public function switchLanguage($lang)
    {
        
        // Set the application locale
        App::setLocale($lang);
        
        // Save the selected language in the session
        Session::put('locale', $lang);

        // Redirect back to the same page
        return redirect()->back();
    }
}
