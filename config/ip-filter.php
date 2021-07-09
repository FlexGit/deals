<?php

return [
	/*
    |--------------------------------------------------------------------------
    | Ip Filter Config
    |--------------------------------------------------------------------------
    |
    | Use one of supported filter methods.
    |
    | Supported: "Black list", "White list"
    |
    */

	// Env - only use filter on listed environments
	'env' => ['production', 'staging', 'local'],

	// White list - List of allowed IP addresses
	'allowed' => [
		'127.0.0.1',
		/*'79.165.125.12',*/
	],

	// Black list - List of denied IP addresses
	'denied' => [],
];
