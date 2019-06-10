<?php
// change the following paths if necessary
$yii=dirname(__FILE__).'/yii16/framework/yii.php';

// auto-set program configuration
$program_host = $_SERVER['HTTP_HOST'];
$yii_debug_flag = false;

// GO-LIVE
if (strpos($program_host, "app.coverage-insight.com") !== false) {
    $config=dirname(__FILE__).'/protected/config/production/main.php';
    $yii_debug_flag = false;
}

// STAGING
else if (strpos($program_host, "agencythriveprogram.com") !== false) {
    $config=dirname(__FILE__).'/protected/config/staging/main.php';
    $yii_debug_flag = false;
}

// DEVELOPMENT
else if (strpos($program_host, "app.coverage-insight.local") !== false 
        || strpos($program_host, "tools.agencythriveprogram.app") !== false 
        || strpos($program_host, "192.168") !== false) 
{
    $config=dirname(__FILE__).'/protected/config/development/main.php';
    $yii_debug_flag = true;
}

else {
    echo 'Environment is Invalid';
    exit;
}

// $config=dirname(__FILE__).'/protected/config/main.php';


// Application Release Version
define('BUILD_RELEASE', 'Release: 3.0.1');

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG', $yii_debug_flag);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);

$app = Yii::createWebApplication($config);

// Added by Joven - Zend Framework autoloader  (Zend 1.11.x)
Yii::import('application.vendor.*');
require "Zend/Loader/Autoloader.php";
Yii::registerAutoloader(array('Zend_Loader_Autoloader','autoload'), true);

// Added by Joven - Authorize.net
$anetsdk = Yii::getPathOfAlias('ext.anetsdk') . "/AuthorizeNet.php";
$anet = AnetConfig::model()->find();
if ($anet == null) {
    echo 'You need to setup your Authorize.net configuration';
    exit;
}
define('AUTHORIZENET_SDK', realpath($anetsdk));
if ($anet->is_sandbox == EnumStatus::PRODUCTION) {
    $api_login_id    = $anet->api_login_id;
    $transaction_key = $anet->transaction_key;
} 
else if ($anet->is_sandbox == EnumStatus::SANDBOX) {
    $api_login_id    = $anet->api_login_id2;
    $transaction_key = $anet->transaction_key2;
}
$is_sandbox = ($anet->is_sandbox == EnumStatus::SANDBOX) ? true : false;

define("AUTHORIZENET_API_LOGIN_ID", $api_login_id);
define("AUTHORIZENET_TRANSACTION_KEY", $transaction_key);
define("AUTHORIZENET_SANDBOX", $is_sandbox);
// define("AUTHORIZENET_API_LOGIN_ID", Yii::app()->params['authorize_api_login_id']);
// define("AUTHORIZENET_TRANSACTION_KEY", Yii::app()->params['authorize_transaction_key']);
// define("AUTHORIZENET_SANDBOX", Yii::app()->params['authorize_sandbox']);


$app->run();
