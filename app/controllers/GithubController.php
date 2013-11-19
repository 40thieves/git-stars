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
			$userResponse = Requests::get($githubUrl . $user . $tokenUrlFragment);
			$userJson = json_decode($userResponse->body);

			// Updates user model
			$userModel = User::createIfDoesNotExist(
				$userJson->login,
				[
					'url' => $userJson->html_url
				]
			);

			// Uses Requests library to make http request for user's starred data
			$starsResponse = Requests::get($githubUrl . $user . '/starred' . $tokenUrlFragment);
			$starJson = json_decode($starsResponse->body);

			foreach($starJson as $star)
			{
				// Updates repo model
				$repoModel = Repo::createIfDoesNotExist(
					$star->name,
					[
						'language' => $star->language,
						'url' => $star->html_url
					]
				);

				// Updates star model
				$starModel = Star::createIfDoesNotExist(
					[
						'user_id' => $userModel->id,
						'repo_id' => $repoModel->id
					]
				);
			}
		}

		return Redirect::to('/');
	}

}