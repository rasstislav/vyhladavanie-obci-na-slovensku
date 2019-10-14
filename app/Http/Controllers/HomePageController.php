<?php

namespace App\Http\Controllers;

class HomePageController extends Controller
{
    /**
     * Show the home page.
     *
     * @return View
     */
    public function __invoke()
    {
        return view('home-page');
    }
}
