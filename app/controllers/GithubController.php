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

	/**
	 * Github OAuth instance
	 * @var object
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
			// Get access token
			$token = $this->github->requestAccessToken($code)->getAccessToken();

			// Redirect to update function, with access token
			return Redirect::to('github/update')->with('token', $token);
		}
		else
		{
			// Get guthub authorisation
			$url = $this->github->getAuthorizationUri();

			// Return to github login url
			return Response::make()->header('Location', (string) $url);
		}
	}

	public function update()
	{
		// Gets oauth access token
		if ( ! $token = Session::get('token'))
			return Redirect::to('github');

		$githubUrl = Config::get('github.url'); // Base github url
		$tokenUrlFragment = '?access_token=' . $token; // Token url fragment

		// List of users to index
		$users = Config::get('recommender.users');

		foreach($users as $user)
		{
			// Uses Requests library to make http request for user data
			$user_response = Requests::get($githubUrl . $user . $tokenUrlFragment);
			$user_json = json_decode($user_response->body);

			// Updates user model
			$user_model = User::createIfDoesNotExist(
				$user_json->login,
				[
					'url' => $user_json->html_url
				]
			);

			// Uses Requests library to make http request for user's starred data
			$stars_response = Requests::get($githubUrl . $user . '/starred' . $tokenUrlFragment);
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

		return Redirect::to('/');
	}

}