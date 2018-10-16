<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Functions;

use Illuminate\Support\Facades\Route;
use Zizaco\Entrust\Entrust;

class HomeController extends BaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {

        $username = Functions::getALUser()->name;

        return view('admin.home',compact('username'));
    }
}
