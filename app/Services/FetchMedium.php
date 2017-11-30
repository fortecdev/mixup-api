<?php

namespace App\Services;

use App\Contracts\ConstructResponse;
use GuzzleHttp\Client as GuzzleClient;

/**
 * Fetch Posts from Medium's API
 */
class FetchMedium implements ConstructResponse
{

	protected $mediumUrl = "http://medium.com/?format=json";

    /**
     * 
     * @return \Illuminate\Support\Collection
    */
    public function getMediumPosts()
    {
        $client = new GuzzleClient();
        $response = $client->request('GET', $this->mediumUrl);

        $parsed =  $this->parseResponse($response->getBody());

        return $this->constructResponse($parsed);
    }

    /**
     * Parse the Medium JSON response
     * 
     * Remove the gibberish string Medium attaches to the beginning of the JSON response, 
     * then get an associative array of the parsed response.
     * 
     * @param string $response
     * @return array
    */
    protected function parseResponse($response)
    {
        return json_decode(str_replace('])}while(1);</x>', '', $response), true);
    }

    /**
     * Set up the Medium response
     * 
     * Manipulate the parsed Medium JSON response 
     * and set up the necessary response structure.
     * The response consists of 20 shuffled posts.
     * 
     * @param array $data
     * @return \Illuminate\Support\Collection
    */
    public function constructResponse($data)
    {
        // Retrieve all posts
        $posts = $data['payload']['references']['Post'];

        // Create an empty collection
        $response = collect();

        foreach ($posts as $post) {

            $title = $post['title'];
            $tags = collect($post['virtuals']['tags']);

            $response->push([
                'title' => $title,
                'subtitle' => array_has($post, 'content.subtitle') ? $post['content']['subtitle'] : '',
                'tags' => $tags->map(function($tag){
                    return $tag['name'];
                }),
                'url' => "https://medium.com/p/{$post['uniqueSlug']}?source=user_popover",
            ]);

        }

        return $response->shuffle()->take(20);
    }

}