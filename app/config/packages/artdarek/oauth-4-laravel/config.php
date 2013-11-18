<?php 

return array( 
	
	/*
	|--------------------------------------------------------------------------
	| oAuth Config
	|--------------------------------------------------------------------------
	*/

	/**
	 * Storage
	 */
	'storage' => 'Session', 

	/**
	 * Consumers
	 */
	'consumers' => array(

		/**
		 * Facebook
		 */
        'Github' => array(
            'client_id'     => 'e8474546bc8db4632fb0',
            'client_secret' => 'b13a6794e21c28be794fbd92cefe8eefe2204b73',
            'scope'         => array(),
        ),
	)
);