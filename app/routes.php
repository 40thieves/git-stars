<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
*/

Route::get('recommend/{repoName}', 'HomeController@recommend');

Route::get('github/update', 'GithubController@update');