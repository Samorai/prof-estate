<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;
use Thunder\SimilarWebApi\ClientFacade as SimilarWebClient;

class IndexController extends BaseController
{
    public function index(Request $request)
    {
        return view('index.twig');
    }

    public function result(Request $request, SimilarWebClient $similarWebClient)
    {
        //$resp = $similarWebClient->getTrafficProResponse('bookimed.com', 'weekly', '06-2015', '10-2015', false);
        return view('result.twig');
    }
}
