<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);
use \yii\web\Request;
$baseUrl = str_replace('/frontend/web', '', (new Request)->getBaseUrl());
//$baseUrl = "";
return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'language'=>'fr_FR',
    'timeZone'=>'Africa/Lome',
    'version'=>'2.1',
    'charset'=>'utf-8',
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [

       
		'request' => [
		 'baseUrl' => $baseUrl,
        // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
			//'cookieValidationKey' => 'qJAWMCCBQcxfEQG0PxfrMXFPXj6Uxltx',
			'cookieValidationKey' => '699e249bacf11ee6936ac35d75331db63e3f3136',
		] ,

        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'baseUrl' => $baseUrl,
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => []
        ]
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
        
    ],

    'modules' => [
       'gridview' =>  [
        'class' => '\kartik\grid\Module',
        // enter optional module parameters below - only if you need to  
        // use your own export download action or custom translation 
        // message source
        // 'downloadAction' => 'gridview/export/download',
        // 'i18n' => []

    ],

    'editeur' => [

        'class' => 'frontend\modules\editeur\Editeur',

    ],

    'impression' => [

            'class' => 'frontend\modules\impression\impression',

        ],
],


'params' => $params,

];
