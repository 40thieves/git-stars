<?php

class User extends Eloquent {

	/**
	 * The database table used by the model
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * Model attributes that can be mass-assigned
	 * @var array
	 */
	protected $fillable = [
		'username',
		'url',
	];

	/**
	 * Model attributes that cannot be mass-assigned
	 * @var array
	 */
	protected $guarded = [
		'id',
	];

	public static function getFirstByUsername($username)
	{
		if ( ! $username)
			App::abort(500, 'No username given');

		return self::where('username', '=', $username)->first();
	}

	/**
	 * Creates model, if model with username does not already exist
	 * @param  string $username Username to create model with
	 * @return Model            Model found or created
	 */
	public static function createIfDoesNotExist($username, $params = [])
	{
		// Queries to find existing user with username
		$user = self::getFirstByUsername($username);

		// If not found, create
		if ( ! $user)
		{
			$user = self::create([
				'username' => $username,
				'url'      => isset($params['url']) ? $params['url'] : null,
			]);
		}

		return $user;
	}

}