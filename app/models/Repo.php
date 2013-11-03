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

	public static function createIfDoesNotExist($name, $options = [])
	{
		// Queries to find existing repo with name
		$repo = self::where('name', '=', $name)->first();

		// If not found, create
		if ( ! $repo)
		{
			$repo = self::create([
				'name'     => $name,
				'language' => isset($options['language']) ? $options['language'] : null,
			]);
		}

		return $repo;
	}

}