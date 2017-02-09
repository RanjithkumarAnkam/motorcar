<?php
//error_reporting(-1);
//ini_set('session.gc_maxlifetime',1);
date_default_timezone_set("America/Chicago");
$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    
    'modules' => [
    
//     'metronic' => [
     
//     'Class' => 'anli\metronic\Module'
   
    
//     		],
    
    		'dynagrid'=> [
    		'class'=>'\kartik\dynagrid\Module'
    				// other module settings
    ],
    'gridview'=> [
    'class'=>'\kartik\grid\Module'
    		// other module settings
    ],
     
    
    'admin' => [
    'class' => 'app\modules\admin\module'
    		],
    		
    				'client' => [
    				'class' => 'app\modules\client\module'
    						],
    						'gii' => [
    						'class' => 'yii\gii\Module',
    						'allowedIPs' => ['*']
    						]
    
    						],
    						
    'components' => [
		'session' => array(
			  'class' => 'yii\web\DbSession',
			  'timeout' => 1800,
		   ),
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'rIPgnCtyzI7Ct8IOF9lUQCemM4hBaF3R',
			'enableCookieValidation' => true,
            'enableCsrfValidation' => false
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'SessionCheck' => [
        'class' => 'app\components\SessionCheckComponent',
        ],
        
        'CustomMail' => [
        'class' => 'app\components\MailComponent',
        ],
		'sendGrid' => [
        'class' => 'bryglen\sendgrid\Mailer',
		'username'=>'sainathb',
       // 'username' => 'sampath_narayanan',
        'password' => 'Password1!',    

		],
        'Permission' => [
        'class' => 'app\components\PermissionComponent',
        ],
		'Sharefile' => [
        'class' => 'app\components\SharefileComponent',
        ],
		'EncryptDecrypt' => [
        'class' => 'app\components\EncryptDecryptComponent',
        ],
		'Rightsignature' => [
        'class' => 'app\components\RightsignatureComponent',
        ],
		
        
        'user'
        		 => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
			'authTimeout' => 10, //Seconds
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
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
        'db' => require(__DIR__ . '/db.php'),
        
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            '<controller:\w+>/<id:\d+>' => '<controller>/view',
            '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
            '<module:\w+>/<controller:\w+>/<action:\w+>/<id:\d+>'=>'<module>/<controller>/<action>',
            '<alias:index|about|contact|login|logout|setaccount|adminlogout|clientlogout|shadowlogin|forgotpassword|verification|sendchangemail|resetpassword>' => 'site/<alias>',
            ],
        ],
        
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
