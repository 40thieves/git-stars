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

}