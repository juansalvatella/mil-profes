<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| oAuth Config
	|--------------------------------------------------------------------------
	|
	| Default: 'storage' => 'Session',
	|
	*/

    'storage' => 'Session',

	'consumers' => [

        'Facebook' => [
            'client_id'     => '1616747608613847',
            'client_secret' => '06d2113a7d99d16875a74289edca1e9d',
            'scope'         => ['email'],
        ],

        'Google' => [
            'client_id'     => '663485310578-c6ema1e3kleb57glhru8hq6sf08j2pva.apps.googleusercontent.com',
            'client_secret' => 'Wc8wQPjwaCzMtIYQECvrqtNN',
            'scope'         => ['userinfo_email', 'userinfo_profile'],
        ],

        'Twitter' => [
            'client_id'     => 'i1V657gMtMTtOgbK3mgbzhokm',
            'client_secret' => '05qyDYiU6ecWrDByetlU0nJl043Y3KhyGloyJNQCPu393tEW8W',
            'scope'         => [],
        ],

    ]

);