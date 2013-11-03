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
	 * Creates model, if model does not already exist
	 * @param  string $name   Repo name to create model with
	 * @param  array  $params Params to create model with
	 * @return Model          Model found to created
	 */
	public static function createIfDoesNotExist($name, $params = [])
	{
		// Queries to find existing repo with name
		$repo = self::where('name', '=', $name)->first();

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