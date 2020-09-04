<?php

namespace SAASBoilerplate\Http\Home\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use SAASBoilerplate\App\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Show the application home page.
     *
     * @return Application|Factory|Response|View
     */
    public function index()
    {
        return view('home.index');
    }
}
