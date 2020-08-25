<?php

namespace SAASBoilerplate\Http\Developer\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use SAASBoilerplate\App\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\View\View;

class DeveloperController extends Controller
{
    /**
     * Display the developer panel view.
     *
     * @return Application|Factory|Response|View
     */
    public function index()
    {
        return view('developer.index');
    }
}
