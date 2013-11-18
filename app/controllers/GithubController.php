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

	private $github;

	public function logInWithGithub()
	{
		// Get data from input
		$code = Input::get('code');

		// Get github service
		$this->github = OAuth::consumer('Github', 'http://gitstars.dev/github');

		// If code is provided get user data and sign in
		if ( ! empty($code))
		{
			// Get callback token
			$this->github->requestAccessToken($code);

			$this->foo();
		}
		else
		{
			// Get guthub authorisation
			$url = $this->github->getAuthorizationUri();

			// Return to github login url
			return Response::make()->header('Location', (string) $url);
		}
	}

	public function foo()
	{
		if ( ! $this->github)
		{
			return Redirect::to('github');
		}

		$result = $this->github->request('/user');
		print_r($result);
	}

	public function update()
	{
		// Base github url
		$github_url = 'https://api.github.com/users/';

		// List of users to index
		$users = Config::get('recommender.users');

		foreach($users as $user)
		{
			// Uses Requests library to make http request for user data
			$user_response = Requests::get($github_url . $user);
			$user_json = json_decode($user_response->body);

			// Updates user model
			$user_model = User::createIfDoesNotExist(
				$user_json->login,
				[
					'url' => $user_json->html_url
				]
			);

			// Uses Requests library to make http request for user's starred data
			$stars_response = Requests::get($github_url . $user . '/starred');
			$stars_json = json_decode($stars_response->body);

			foreach($stars_json as $star)
			{
				// Updates repo model
				$repo_model = Repo::createIfDoesNotExist(
					$star->name,
					[
						'language' => $star->language,
						'url' => $star->html_url
					]
				);

				// Updates star model
				$star_model = Star::createIfDoesNotExist(
					[
						'user_id' => $user_model->id,
						'repo_id' => $repo_model->id
					]
				);
			}
		}
	}

}