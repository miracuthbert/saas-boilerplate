<?php

namespace SAAS\Http\Admin\Controllers\User;

use SAAS\App\Controllers\Controller;
use SAAS\Domain\Users\Models\User;
use Illuminate\Http\Request;
use SAAS\App\Actions\Fortify\CreateNewUser;
use Illuminate\Auth\Events\Registered;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request)
    {
        $this->authorize('create', User::class);

        $users = User::filter($request)->paginate();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', User::class);

        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, CreateNewUser $user)
    {
        $this->authorize('create', User::class);

        $user->create($request->all(), ['terms', 'password'], true);

        return back()->withSuccess(__('User created successfully.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \SAAS\Domain\Users\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $this->authorize('view', $user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \SAAS\Domain\Users\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $this->authorize('update', $user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \SAAS\Domain\Users\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \SAAS\Domain\Users\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);
    }
}
