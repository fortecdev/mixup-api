<?php

namespace App\Services;

use GuzzleHttp\Psr7\Stream;
use App\Contracts\ConstructResponse;
use GuzzleHttp\Client as GuzzleClient;

/**
 * summary
 */
class FetchHackerNews implements ConstructResponse
{

	protected $client;

	protected $topPostsUrl;

	protected $baseUrl = "https://hacker-news.firebaseio.com/v0";

	public function __construct()
	{
		$this->client = new GuzzleClient();

		$this->topPostsUrl = $this->baseUrl . "/topstories.json?print=pretty";
	}

	/**
	 * Get top posts from HackerNews
	 * 
	 * @return \Illuminate\Support\Collection
	*/
	public function getHackerNewsPosts()
	{
		$response = $this->client->request('GET', $this->topPostsUrl);

		return $this->constructResponse($response->getBody());
	}

	/**
	 * 
	 * @param array
	 * @return \Illuminate\Support\Collection
	*/
	public function constructResponse($data)
	{
		$parsed = $this->parseResponse($data);

		// Pick the first 20 post ids
		$items = array_slice($parsed, 0, 20, true);

		$posts = collect();

		// Fetch the post details for every post ID
		foreach ($items as $postId) {

			$post = $this->getPost($postId);

			$posts->push([
				'id' => $post['id'],
				'url' => array_has($post, 'url') ? $post['url'] : '' ,
				'author' => $post['by'],
				'title' => $post['title'],
				'score' => $post['score'],
				'comments' => array_has($post, 'descendants') ? $post['descendants'] : 0 , 
				'comments_link' => "https://news.ycombinator.com/item?id=" . $post['id'],
			]);

		}

		return $posts;
	}

	/**
	 * Parse the response from HackerNews
	 * 
	 * The response from HackerNews comes as a Stream format 
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

	/**
	 * Fetch the details of a particular post
	 * 
	 * @param int $id
	 * @return array
	*/
	protected function getPost($id)
	{
		$postResponse = $this->client->request('GET', $this->singlePostUrl($id));

		return $this->parseResponse($postResponse->getBody());
	}

	/**
	 * The url for fetching the details of a single post on HN
	 * 
	 * @return string
	*/
	protected function singlePostUrl($postId)
	{
		return $this->baseUrl . "/item/" . $postId . ".json?print=pretty";
	}

}