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

		$reposGithubUrl = Config::get('github.urls.repos');
		$usersGithubUrl = Config::get('github.urls.users');
		$tokenUrlFragment = '?access_token=' . $token;

		// Sets url for users data - using sample repos Casper (117 stars) or var_dumpling (17 stars)
		$baseRepo = Config::get('github.baseRepos.lowStars');
		// $baseRepo = Config::get('github.baseRepos.highStars');
		$url = $reposGithubUrl . $baseRepo . '/stargazers' . $tokenUrlFragment;

		// Fetch users
		$users = $this->recursiveFetch($url);

		// Loops through all users to fetch and star their starred data
		foreach ($users as $user)
		{
			// Creates user model
			$userModel = User::createIfDoesNotExist(
				$user->login,
				['url' => $user->html_url]
			);

			// Request for user's starred data
			$starsUrl = $usersGithubUrl . $user->login . '/starred' . $tokenUrlFragment;
			$stars = $this->recursiveFetch($starsUrl);

			foreach ($stars as $star)
			{
				// Creates repo model
				$repoModel = Repo::createIfDoesNotExist(
					$star->name,
					['url' => $star->html_url]
				);

				// Creates star model
				$starModel = Star::createIfDoesNotExist([
					'user_id' => $userModel->id,
					'repo_id' => $repoModel->id,
				]);
			}
		}

		return Redirect::to('/');
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

			if ($response->status_code == 200)
			{
				// Decode response body
				$json = json_decode($response->body);

				if ( ! is_array($json))
					App::abort(500, 'JSON not an array');
				// Join with previous responses
				$ret = array_merge($ret, $json);
			}

			$i++;
		// If last page link is included in header, continue to fetch next page
		} while (preg_match('/rel="last"/', $header) === 1);

		return $ret;
	}

}