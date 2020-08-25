<?php

namespace SAASBoilerplate\Http\Admin\Controllers\User;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use SAASBoilerplate\App\Controllers\Controller;
use SAASBoilerplate\Domain\Admin\Requests\ImpersonateStartRequest;
use SAASBoilerplate\Domain\Users\Models\User;
use Illuminate\Http\Response;
use Illuminate\View\View;

class UserImpersonateController extends Controller
{
    /**
     * Show impersonation form.
     *
     * @return Application|Factory|Response|View
     */
    public function index()
    {
        return view('admin.users.impersonate.index');
    }

    /**
     * Setup and start user impersonation.
     *
     * @param ImpersonateStartRequest $request
     * @return RedirectResponse
     */
    public function store(ImpersonateStartRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        session()->put('impersonate', $user->id);

        return redirect()->route('account.dashboard')
            ->with('success', "You are now impersonating {$user->name}");
    }

    /**
     * Setup and start user impersonation.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function destroy(Request $request)
    {
        session()->forget('impersonate');

        return redirect()->route('account.dashboard');
    }
}
