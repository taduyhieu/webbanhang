<?php

namespace Fully\Http\Controllers;

/**
 * Class LanguageController.
 *
 * @author THC <thanhhaconnection@gmail.com>
 */
class LanguageController extends Controller
{
    public function setLocale($language)
    {
        LaravelLocalization::setLocale($language);
        return Redirect::route('dashboard');
    }
}
