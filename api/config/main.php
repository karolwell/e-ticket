<?php

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),    
    'bootstrap' => ['log'],
    'modules' => [
        'v1' => [
            'basePath' => '@app/modules/v1',
            'class' => 'api\modules\v1\Module'
        ]
    ],
    'components' => [        
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => false,
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
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule', 
                    'controller' => 'v1/country',
                    'tokens' => [
                        '{id}' => '<id:\\w+>'
                    ]
                    
                ],
               [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['v1/ussd'],
                    'tokens' => [
                        '{id}' => '<id:\\w+>'
                    ], 'extraPatterns' => [
                        'POST getdata' => 'getdata',
                        'POST getdatatest' => 'getdatatest',
                    ]
                ],
               [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['v1/tmoney'],
                    'tokens' => [
                        '{id}' => '<id:\\w+>'
                    ], 'extraPatterns' => [
                        'GET get_user_solde' => 'get_user_solde',
                        'POST getdatatest' => 'getdatatest',
                    ]
                ],
               [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['v1/facture'],
                    'tokens' => [
                        '{id}' => '<id:\\w+>'
                    ], 'extraPatterns' => [
                        'GET get_user_solde' => 'get_user_solde',
                        'GET get' => 'get',
                        'POST get' => 'get',
                        'POST get_date' => 'get_date',
                    ]
                ],
            ],        
        ]
    ],
    'params' => $params,
];



