<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        /* Redirect the user to the users view in case the start was successful */
        return redirect()->route('index.users');
    }

    public function indexroles()
    {
        /* Validate that the user has permission to and enters the corresponding view */
        abort_if(Gate::denies('roles.index'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('panel.roles.index');
    }

    public function changeLang($lang)
    {
        if (!in_array($lang, ['en', 'es'])) {
            abort(400);
        }
        // App::setLocale($lang);
        session()->put('locale', $lang);

        return redirect()->back();
    }
}
