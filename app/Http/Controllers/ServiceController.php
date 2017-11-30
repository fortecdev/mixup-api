<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\DetermineService;
use App\Traits\DetermineNewsService;

class ServiceController extends Controller
{

	use DetermineService, DetermineNewsService;
    
    public function getService(Request $request)
    {
    	$service = $this->fetchService($request);

    	return response()->json($service, 200);
    }

    public function getNews(Request $request)
    {
    	return $this->fetchNews();
    }

}
