<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        // $post = $request->all();
        // echo'<pre>';
        // print_r($request['roles']);
        // exit;
        
    }
}
