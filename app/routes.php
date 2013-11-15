<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
*/

Route::get('/', function() {
	return View::make('hello');
});

Route::get('recommend', function() {
	$repoName = Input::get('repo-name');

	if ($repoName)
		return Redirect::to('recommend/' . $repoName);
});

Route::get('recommend/{repoName}', 'RecommendController@recommend');

Route::get('github/update', 'GithubController@update');

App::error(function(Exception $exception) {
	return View::make('error');
});