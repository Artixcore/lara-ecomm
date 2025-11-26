<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LanguageController extends Controller
{
    public function switch(Request $request, string $locale)
    {
        $availableLocales = ['en', 'es', 'fr', 'de'];
        
        if (!in_array($locale, $availableLocales)) {
            return redirect()->back()->with('error', 'Language not supported');
        }

        session(['locale' => $locale]);
        
        if (Auth::check()) {
            Auth::user()->update(['language' => $locale]);
        }

        app()->setLocale($locale);

        return redirect()->back();
    }
}
