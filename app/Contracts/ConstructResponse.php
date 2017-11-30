<?php

namespace App\Contracts;

interface ConstructResponse{

	/**
	 * Set up the needed response structure.
	 * 
	 * @param array
	 * @return \Illuminate\Support\Collection
	*/
	public function constructResponse($data);

}