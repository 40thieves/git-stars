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
		// Base github url
		$github_url = 'https://api.github.com/users/';

		// List of users to index
		$users = [
			'40thieves',
			'edpoole',
			'rmlewisuk',
			'danharper',
		];

		foreach($users as $user)
		{
			// Uses Requests library to make http request for user data
			$user_response = Requests::get($github_url . $user);
			$user_json = json_decode($user_response->body);

			// Updates user model
			$user_model = User::createIfDoesNotExist($user_json->login);

			// Uses Requests library to make http request for user's starred data
			$stars_response = Requests::get($github_url . $user . '/starred');
			$stars_json = json_decode($stars_response->body);

			foreach($stars_json as $star)
			{
				// Updates repo model
				$repo_model = Repo::createIfDoesNotExist($star->name, ['language' => $star->language]);

				// Updates star model
				$star_model = Star::createIfDoesNotExist(['user_id' => $user_model->id, 'repo_id' => $repo_model->id]);
			}
		}
	}

}