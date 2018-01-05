<?php

namespace App\Services;

use Goutte\Client as GoutteClient;
use App\Contracts\ParseResponse;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Fetch featured stories from indiehackers homepage
 */
class FetchIndieHackers extends ParseResponse
{

	/**
	 * @var \Goutte\Client
	*/
	protected $client;

    public function __construct()
    {
		$this->client = new GoutteClient();
    }

    public function getFeaturedStories()
    {
		$crawler = $this->client->request('GET', "http://indiehackers.com");

		$response = $this->parseResponse($crawler);

		return $response;
    }

	/**
	 * Scrape the page for featured stories
	 * 
	 * @param \Symfony\Component\DomCrawler\Crawler $crawler
	*/
    public function parseResponse(Crawler $crawler)
    {
		$responseData = collect();

		$crawler->filter('.homepage__content div.featured-story')->each(function($node) use ($responseData) {
			$title = $this->toString($node->filter('h3.featured-story__title')->extract('_text'));

			$subtitle = $this->toString($node->filter('p.featured-story__description')->extract('_text'));

			$url = '';

			$score = $this->toString($node->filter('div.thread-voter__count')->extract('_text'));

			$comment_count = trim(str_before($this->toString($node->filter('span.story-actions__label')->extract('_text')), 'comments'));

			$responseData->push([
				'title' => $title,
				'subtitle' => $subtitle,
				'url' => $url,
				'score' => $score,
				'comment_count' => $comment_count,
			]);

		});

		return $responseData;

    }

}