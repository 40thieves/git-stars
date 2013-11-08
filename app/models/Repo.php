<?php

class Repo extends Eloquent {

	/**
	 * The database table used by the model
	 * @var string
	 */
	protected $table = 'repos';

	/**
	 * Model attributes that can be mass-assigned
	 * @var array
	 */
	protected $fillable = [
		'name',
		'language',
	];

	/**
	 * Model attributes that cannot be mass-assigned
	 * @var array
	 */
	protected $guarded = [
		'id',
	];

	/**
	 * Gets all repos, but separates the selected repo in the return array
	 * @param  string $name Repo name to select
	 * @return array        Array containing selected repo first, then collection of all other repos
	 */
	public static function getAllWithSelectedByName($name)
	{
		$all = self::getAll();

		$selected = $all->filter(function($one) use ($name) {
			if ($one->name == $name)
				return true;
		});

		$all = $all->filter(function($one) use ($name) {
			if ($one->name != $name)
				return true;
		});

		return [$selected->first(), $all];
	}

	public static function getAll()
	{
		return self::all();
	}

	/**
	 * Queries model to find the first repo with name (should be unique)
	 * @param  string $name Repo name
	 * @return Model        Repo model found
	 */
	public static function getFirstByName($name)
	{
		if ( ! $name)
			App::abort(500, 'No name given');

		return self::where('name', '=', $name)->first();
	}

	/**
	 * Creates model, if model does not already exist
	 * @param  string $name   Repo name to create model with
	 * @param  array  $params Params to create model with
	 * @return Model          Model found to created
	 */
	public static function createIfDoesNotExist($name, $params = [])
	{
		$repo = self::getFirstByName($name);

		// If not found, create
		if ( ! $repo)
		{
			$repo = self::create([
				'name'     => $name,
				'language' => isset($params['language']) ? $params['language'] : null,
			]);
		}

		return $repo;
	}

}