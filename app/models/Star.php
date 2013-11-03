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

}