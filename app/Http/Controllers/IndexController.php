<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class IndexController extends BaseController
{
    public function index(Request $request)
    {
        return view('index.twig');
    }

    public function form(Request $request)
    {
        return view('form.twig');
    }
}
