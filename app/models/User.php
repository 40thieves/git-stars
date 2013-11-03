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


}