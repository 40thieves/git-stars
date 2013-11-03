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
	];

	/**
	 * Model attributes that cannot be mass-assigned
	 * @var array
	 */
	protected $guarded = [
		'id',
	];

	/**
	 * Creates model, if model with username does not already exist
	 * @param  string $username Username to create model with
	 * @return Model            Model found or created
	 */
	public static function createIfDoesNotExist($username)
	{
		// Queries to find existing user with username
		$user = self::where('username', '=', $username)->first();

		// If not found, create
		if ( ! $user)
		{
			$user = self::create([
				'username' => $username
			]);
		}

		return $user;
	}

}