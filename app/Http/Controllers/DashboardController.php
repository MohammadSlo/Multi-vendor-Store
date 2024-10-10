<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{


public function __construct()
{
    //this means that every action(method) in this class will be executed only if user is authenticated
    $this->middleware(['auth']);
}


  public  function index() {
        

        return view('dashboard.index', [
        ]);
    }
}
