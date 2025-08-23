<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display other static pages
     */
    public function login()
    {
        return view('auth.login');
    }

    public function catering()
    {
        return view('catering');
    }

    public function account()
    {
        return view('account');
    }

    public function search()
    {
        return view('search');
    }

    public function contact()
    {
        return view('contact');
    }
}
