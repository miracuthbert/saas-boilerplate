<?php

namespace SAAS\Http\Home\Controllers;

use Illuminate\Http\Request;
use SAAS\App\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Show the application home page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home.index');
    }
}
