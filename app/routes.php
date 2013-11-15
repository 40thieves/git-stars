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

Route::get('recommend/{repoName}', 'RecommendController@recommend');

Route::get('github/update', 'GithubController@update');