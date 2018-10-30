<?php
return [
	'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
	'components' => [
		'cache' => [
			'class' => 'yii\caching\FileCache',
		],

		'request' => [
        // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
			//'cookieValidationKey' => 'qJAWMCCBQcxfEQG0PxfrMXFPXj6Uxltx',
			'cookieValidationKey' => '699e249bacf11ee6936ac35d75331db63e3f3136',
		]     
	],
];
