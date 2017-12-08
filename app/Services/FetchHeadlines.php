<?php

namespace App\Services;

use GuzzleHttp\Psr7\Stream;
use GuzzleHttp\Client as GuzzleClient;

/**
 * summary
 */
class FetchHeadlines
{

    /**
     * Developer api key from NewsAPI
     * 
     * @var string
    */
    protected $apiKey;

    /**
     * The news source
     * 
     * @var string
    */
	protected $source;

    /**
     * @param string $newsSource
     */
    public function __construct($newsSource)
    {
    	$this->source = $newsSource;
        $this->apiKey = config('services.newsapi.API_KEY');
    }

    /**
     * Fetch headlines from NewsAPI
     * 
     * @return array
    */
    public function getNewsHeadlines()
    {
    	$url = "https://newsapi.org/v2/top-headlines?sources={$this->source}";

    	$client = new GuzzleClient();

    	$response = $client->request('GET', $url, [
    		'headers' => [
    			'X-Api-Key' => $this->apiKey,
    		]
		]);

		return $this->parseResponse($response->getBody());
    }

	/**
	 * Parse the response from NewsAPI
	 * 
	 * The response from NewsAPI comes as a Stream class 
	 * so we need to retrieve the streamed response,
	 * and convert it into an associative array.
	 * 
	 * @param \GuzzleHttp\Psr7\Stream $response
	 * @return array
	*/
	public function parseResponse(Stream $response)
	{
		$streamResponse = $response->getContents();

		return json_decode($streamResponse, true);
	}

}