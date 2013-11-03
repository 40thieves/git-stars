<?php

class GithubController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Github Controller
	|--------------------------------------------------------------------------
	|
	| Controller to update database using Github API
	|
	*/

	public function update()
	{
		$github_url = 'https://api.github.com/users/';

		// $users = [
		// 	'40thieves',
		// 	'edpoole',
		// 	'rmlewisuk',
		// 	'danharper',
		// ];

		// Uses Requests library to make http request
		$user_response = Requests::get($github_url . '40thieves');
		$user_json = json_decode($user_response->body);

		// Updates user model
		$user = User::createIfDoesNotExist($user_json->login);

		// Uses Requests library to make http request
		$stars_response = Requests::get($github_url . '40thieves/starred');
		$stars_json = json_decode($stars_response->body);

		foreach($stars_json as $star)
		{
			$repo = Repo::createIfDoesNotExist($star->name, ['language' => $star->language]);

			$foo = Star::createIfDoesNotExist(['user_id' => $user->id, 'repo_id' => $repo->id]);
		}
	}

}