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
		$repo = Repo::getFirstByName($repoName);

		$repoStars = Star::getAllByRepoId($repo->id);
	}

}