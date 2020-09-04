<?php

namespace SAASBoilerplate\Http\Admin\Controllers\User;

use SAASBoilerplate\App\Controllers\Controller;
use SAASBoilerplate\Domain\Users\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Application|Factory|Response|View
     * @throws AuthorizationException
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
     * @return void
     * @throws AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', User::class);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return void
     * @throws AuthorizationException
     */
    public function store(Request $request)
    {
        $this->authorize('create', User::class);
    }

    /**
     * Display the specified resource.
     *
     * @param  User  $user
     * @return void
     * @throws AuthorizationException
     */
    public function show(User $user)
    {
        $this->authorize('view', $user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  User  $user
     * @return void
     * @throws AuthorizationException
     */
    public function edit(User $user)
    {
        $this->authorize('update', $user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  User  $user
     * @return void
     * @throws AuthorizationException
     */
    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User  $user
     * @return void
     * @throws AuthorizationException
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);
    }
}
