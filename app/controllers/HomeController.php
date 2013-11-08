<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	*/

	public function recommend($repoName)
	{
		list($repo, $allRepos) = Repo::getAllWithSelectedByName($repoName);

		$repoMatrix = Star::generateMatrixByRepoId($repo->id);
	}

}