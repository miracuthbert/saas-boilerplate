<?php

namespace SAASBoilerplate\Http\Home\Controllers;

use Illuminate\Http\Request;
use SAASBoilerplate\App\Controllers\Controller;

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
