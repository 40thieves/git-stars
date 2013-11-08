<?php

class Star extends Eloquent {

	/**
	 * The database table used by the model
	 * @var string
	 */
	protected $table = 'stars';

	/**
	 * Turns off automatic timestamps (created_at and updated_at)
	 * @var boolean
	 */
	public $timestamps = false;

	/**
	 * Model attributes that can be mass-assigned
	 * @var array
	 */
	protected $fillable = [
		'repo_id',
		'user_id',
	];

	/**
	 * Model attributes that cannot be mass-assigned
	 * @var array
	 */
	protected $guarded = [
		'id',
	];

	public static function getAllByRepoId($repoId)
	{
		return self::where('repo_id', '=', $repoId)->get();
	}

	public static function generateMatrixByRepoId($repoId)
	{
		$stars = self::getAllByRepoId($repoId);

		$matrix = Config::get('recommender.blankMatrix'); // Blank matrix

		foreach($stars as $star)
		{
			$matrix[$star->user_id - 1] = 1;
		}

		return $matrix;
	}

	public static function createIfDoesNotExist($params)
	{
		if ( ! isset($params['user_id']))
			App::abort(500, 'User ID not set');

		if ( ! isset($params['repo_id']))
			App::abort(500, 'Repo ID not set');

		$user_id = $params['user_id'];
		$repo_id = $params['repo_id'];

		// Queries to find existing star with same user_id and repo_id
		$star = self::where('user_id', '=', $user_id)
			->where('repo_id', '=', $repo_id)
			->first();

		// If not found, create
		if ( ! $star)
		{
			$star = self::create([
				'user_id' => $user_id,
				'repo_id' => $repo_id,
			]);
		}

		return $star;
	}

}