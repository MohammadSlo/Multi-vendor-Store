<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function __construct()
    {
        //this means that every action(method) in this class will be executed only if user is authenticated
        $this->middleware(['auth']);
    }

    public function index()
    {

        return view('dashboard.index', [
        ]);
    }
}
