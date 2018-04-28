<?php

namespace SAASBoilerplate\Http\Account\Controllers\Company;

use SAASBoilerplate\Domain\Company\Models\Company;
use Illuminate\Http\Request;
use SAASBoilerplate\App\Controllers\Controller;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $companies = $request->user()->companies;

        return view('account.companies.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('account.companies.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $company = new Company;
        $company->fill($request->only('name', 'email'));
        $company->save();

        $request->user()->companies()->syncWithoutDetaching($company->id);

        return redirect()->route('tenant.dashboard', $company)
            ->withSuccess('Company created successfully.');
    }
}
