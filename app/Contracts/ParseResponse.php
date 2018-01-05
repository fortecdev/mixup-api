<?php

namespace App\Contracts;

use Symfony\Component\DomCrawler\Crawler;

abstract class ParseResponse{

	/**
	 * Set up the needed response structure.
	 * 
	 * @param array
	 * @return \Illuminate\Support\Collection
	*/
	abstract public function parseResponse(Crawler $crawler);

	/**
	 * Convert the document text to a string
	 * 
	 * Since the extract() method returns an array,
	 * we would convert that array into its own string,
	 * and remove trim the string.
	 * 
	 * @param array
	 * @return string
	*/
	public function toString($arr)
	{
		return trim(implode(' ', $arr));
	}

}