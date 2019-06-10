<?php
/**************************  DEVELOPMENT ***********************/

// This is the main Web application configuration
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '../../',
    'name' => 'Coverage Insight',
    
    // preloading 'log' component
    'preload' => array(
        'log'
    ),
    
    // autoloading model and component, custom classes
    'import' => array(
        'application.classes.*',
        'application.models.*',
        'application.components.*',
        'ext.EExcelView.*',
    ),
    
    'modules' => array(
        // Gii tool
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => 'Letmein12@',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters' => array(
                '127.0.0.1',
                '::1'
            )
        ),
        'admin' => [],
    ),
    
    // application components
    'components' => array(
        
        // user library
        'user' => array(
            // enable cookie-based authentication
            'allowAutoLogin' => true,
            'class' => 'WebUser'
        ),
        
        // excel library
        'yexcel' => array(
            'class' => 'ext.yexcel.Yexcel'
        ),

        
        // enable URLs in path-format
        'urlManager' => array(
            'urlFormat' => 'path',
            'rules' => array(
                // Admin Console
                'admin' => 'admin/site/login',
                'admin/<controller:\w+>/<id:\d+>' => 'admin/<controller>/view',
                'admin/<controller:\w+>/<action:\w+>/<id:\d+>' => 'admin/<controller>/<action>',
                'admin/<controller:\w+>/<action:\w+>' => 'admin/<controller>/<action>',
                
                // Client
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>'
            ),
            'showScriptName' => false,
            'caseSensitive' => false
        ),
        
        'securityManager'=>array(
            'cryptAlgorithm' => 'blowfish',
            'encryptionKey' => '06072017',
        ),
        
        // remove some standard yii script
        'clientScript' => array(
            'coreScriptPosition' => CClientScript::POS_END,
            
            // disable default some core yii scripts
            'scriptMap' => array(
                'jquery.js' => false,
                'jquery.min.js' => false,
                'core.css' => false,
                'styles.css' => false,
                'pager.css' => false,
                'default.css' => false
            )
        ),
        
        // database settings are configured in database.php
        'db' => require (dirname(__FILE__) . '/database.php'),
        
        'errorHandler' => array(
            // use 'site/error' action to display errors
            'errorAction' => 'site/error'
        ),
        
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
//                 array(
//                     'class' => 'CFileLogRoute',
//                     'levels' => 'error, warning'
//                 ),
                // show log messages on web pages
                array(
                    'class'=>'CWebLogRoute',
                    'levels' => 'error'
                ),
            )
        )
    
    ),
    
    // application parameters accessed by Yii::app()->params['??????']
    'params' => array(
        
        // Company details
        'company_name' => 'The Engagex Corporation',
        'company_address' => '511 East 1860<br>South Provo, UT 84606<br>United States',
        
        // This is used in contact page
        'adminEmail' => 'admin@agencythriveprogram.local',
        'noreplyEmail' => 'messages-noreply@agencythriveprogram.local',
        'adminSMTPHost' => 'agencythriveprogram.local',
        'adminSMTPPort' => '25',
        'adminSMTPEmail' => 'joven@agencythriveprogram.local',
        'adminSMTPPassword' => 'Letmein12@',
        
        // Email for Checking Status
        'adminSMTPTest' => 'at-test@agencythriveprogram.local',
        
        // Authorize.net Billing Module
        'authorize_api_login_id' => '3qv8XvM9tB4N',
        'authorize_transaction_key' => '64M57a2M52fEjvbr', 
        'authorize_sandbox' => true,

        // Remote support
        'remotesupport' => 'https://appear.in/',

        // Cloudinary Default Account
        'cl_cloud_name' => 'dugzxvsa2',
        
        // Cloudinary API Keys and Secrets
        'cl_api_key_1' => '847512328576339',
        'cl_api_secret_1' => 'eONOND41W8DzsMFHc0iq7nVG8Lg',
        
        // Cloudinary Company Logo Destination
        'cl_upload_preset' => 'rmwqyp2t',
        
        // Cloudinary Client Resource Document
        'cl_client_docs_preset' => 'client_documents',
        
        // Cloudinary Company Logo Transformation
        // 'cl_transformation' => 'c_scale,h_183,w_448',   // resizing
        'cl_transformation' => 'fl_progressive:none.rasterize',

        // Cloudinary Upload Email Images
        'cl_email_editor'=>array(
            'api_key'=>'',
            'api_secret'=>''
        ),
        
        // Application Build Version
        // Reminder: Please dont forget to update realease-notes.txt
        'buildVersion' => BUILD_RELEASE . '(development)'
    )
);
