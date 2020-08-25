<?php

namespace SAASBoilerplate\Http\Account\Controllers\Company;

use SAASBoilerplate\Domain\Company\Models\Company;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use SAASBoilerplate\App\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\View\View;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Application|Factory|Response|View
     */
    public function index(Request $request)
    {
        $companies = $request->user()->companies;

        return view('account.companies.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|Response|View
     */
    public function create()
    {
        return view('account.companies.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $company = new Company;
        $company->fill($request->only('name', 'email'));
        $company->save();

        $request->user()->companies()->syncWithoutDetaching($company->id);

        return redirect()->route('tenant.dashboard', $company)
            ->with('success','Company created successfully.');
    }
}
