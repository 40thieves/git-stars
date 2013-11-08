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

		// $repoStars = Star::countAllByRepoId($repo->id);
		$repoMatrix = Star::generateMatrixByRepoId($repo->id);
	}

}