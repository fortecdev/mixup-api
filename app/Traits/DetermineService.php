<?php

namespace App\Traits;

use Illuminate\Http\Request;
use App\Services\FetchMedium;
use App\Services\FetchHackerNews;

/**
 * summary
 */
trait DetermineService
{

    protected $fetch;

    public function fetchService(Request $request)
    {
        $service = $request->service;

    	return $this->determineService($service);
    }

    protected function determineService($service)
    {
    	if ($service == "github") {

    	}
        elseif ($service == "hackernews") {
            $this->fetch = new FetchHackerNews();
            return $this->fetch->getHackerNewsPosts();
        }
    	elseif ($service == "medium") {
    		$this->fetch = new FetchMedium();
            return $this->fetch->getMediumPosts();
    	}
    	elseif ($service == "producthunt") {
    		
    	}
    }

}