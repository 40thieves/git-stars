<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| 
	|
	*/

	public function recommend($repoName)
	{
		$item = Repo::getFirstByName($repoName);
		$items = Repo::getAllExceptId($item->id);

		
	}

}