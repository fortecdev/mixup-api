<?php

namespace App\Traits;

use Illuminate\Http\Request;
use App\Services\FetchGitHub;
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

        switch ($service) {

            case "producthunt":
                // code...
                break;
            case "github":
                $this->fetch = new FetchGitHub();
                return $this->fetch->getGitHubRepos();
                break;
            case "hackernews":
                $this->fetch = new FetchHackerNews();
                return $this->fetch->getHackerNewsPosts();
                break;
            case "medium":
                $this->fetch = new FetchMedium();
                return $this->fetch->getMediumPosts();
                break;

            default:
                // code...
                break;
        }

    }

}