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
			if ($redirect = Session::get('redirect'))
				return Redirect::to($redirect)->with('token', $token);
			else
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
			return Redirect::to('github')->with('redirect', 'github/update');

		$githubUrl = Config::get('github.urls.users'); // Base github url
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

	public function foo()
	{
		// Gets oauth access token
		if ( ! $token = Session::get('token'))
			return Redirect::to('github')->with('redirect', 'github/foo');

		$githubUrl = Config::get('github.urls.repos');
		$tokenUrlFragment = '?access_token=' . $token;

		$url = $githubUrl . 'TryGhost/Casper/stargazers' . $tokenUrlFragment;

		$response = $this->recursiveFetch($url);

		return $response;
	}

	private function recursiveFetch($url)
	{
		$ret = [];
		$i = 1;
		do {
			// Add page numbers past page 1
			if ($i > 1)
				$url = $url . "&page=$i";

			// Make request
			$response = Requests::get($url);

			// Get response headers
			$header = $response->headers['link'];

			// Decode response body
			$json = json_decode($response->body);

			if ( ! is_array($json))
				App::abort(500, 'JSON not an array');
			// Join with previous responses
			$ret = array_merge($ret, $json);

			$i++;
		// If last page link is included in header, continue to fetch next page
		} while (preg_match('/rel="last"/', $header) === 1);

		return $ret;
	}

}