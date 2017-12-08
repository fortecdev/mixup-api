<?php

namespace App\Traits;

use Illuminate\Http\Request;
use App\Services\FetchHeadlines;

/**
 * summary
 */
trait DetermineNewsService
{

    public function fetchNews(Request $request)
    {
		$headline = new FetchHeadlines($request->service);
    	return $headline->getNewsHeadlines();
    }

}