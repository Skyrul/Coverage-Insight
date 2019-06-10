<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends BaseController 
{

    protected function beforeAction($action) 
    {

        // Set default timezone
        if (isset(Yii::app()->session['account_id'])) {
            $dbt = AccountSetup::model()->findByPk(Yii::app()->session['account_id']);
            if ($dbt != null) {
                if ($dbt->timezone != null) {
                    Yii::app()->session['timezone'] = $dbt->timezone;
                    date_default_timezone_set($dbt->timezone);
                }
            }
        }

        // Error handler
        if($error=Yii::app()->errorHandler->error) {
            $this->renderPartial('error', $error);
            exit;
        }

        // Links
        $login_link = '<br><br>You can <a href="'. $this->programURL() .'/site/login">Login</a>';
        $logout_link = '<br><br>You can <a href="'. $this->programURL() .'/site/logout">Logout</a>';


        /* START: WHEN LOGGEDIN */
        // Allowed controller when loggedin
        $allowed_controller_whenlogged = array(
            'agency',
            'account',
            'customer',
            'accountItem',
            'feedback',
            'setup',
            'dashboard',
            'agentprep',
            'needassessment',
            'cir',
            'billing',
            'staff',
            'videoconference',

            'tests',
            'post',
            'dialog',
            'browse',
            'carquery',
            'api',
            'creditcardsettings',
            'emailtemplate',
            'emailpreview',
            'giftcards',
            'permission',            
            'reports',
        );
        /* END: WHEN LOGGEDIN */


        /* START: NOT LOGGEDIN */
        // Allowed controller not loggedin
        $allowed_controller_notlogged = array(
            'site',
            'carquery',
            'videoconference',
        );
        // Allowed not loggedin /site/<method>
        $allowed_page_notlogged = array(
            'index',
            'login',
            'create_account',
            'success',
            'activate',
            'forgot_password',
            'reset_password',
            'access',
            'staff_verification',
            'staff_verified',
            'cron',
            'test_email',
            'test_security',
            'customerviewer'
        );
        /* END: NOT LOGGEDIN */

        // Get logged_in flag
        $access_granted = Yii::app()->session['access_granted'];

        // Default page
        if (($access_granted) && $this->id == 'site' && $this->action->id == 'index') {
            $this->redirect($this->programURL() . '/agency/index');
        }
        if ((!$access_granted) && $this->id == 'site' && $this->action->id == 'index') {
            $this->redirect($this->programURL() . '/site/login');
        }

        // Logout
        if ($this->action->id == 'logout') {
            Yii::app()->user->logout();
            Yii::app()->session->clear();
            $this->redirect($this->programURL() . '/site/login');
        }


        if ($access_granted) {
            $controller_ok = false;

            // By controller
            if (in_array($this->id, $allowed_controller_whenlogged)) {
                $controller_ok = true;    
            }
            
            if ($controller_ok == true) {
                // Access
                if ($this->action->id =='access') {
                    echo 'You are not allowed to access <strong>Need Assessment Link for Customer</strong>. Please logout if you really want to proceed to the Assessment page.<br><br>';
                    echo '<a href="/site/logout">Logout</a>';
                    exit;
                }
                // Staff Verification
                if ($this->action->id =='staff_verification') {
                    echo 'You are not allowed to access <strong>Staff Verification</strong> If your currently on session. Please try to logout first<br><br>';
                    echo '<a href="/site/logout">Logout</a>';
                    exit;
                } 

                return parent::beforeAction($action);
            }
            else {
                echo 'Invalid page [USER_LOGGED-IN]'.$logout_link;
                exit;
            }
        }
        else if (!$access_granted) {
            $controller_ok = false;
            $page_ok = false;

            // By controller
            if (in_array($this->id, $allowed_controller_notlogged)) {
                $controller_ok = true;
            }

            // By page
            if (in_array($this->action->id, $allowed_page_notlogged)) {
                $page_ok = true;
            }

            if ($controller_ok == true && $page_ok == true) {
                return parent::beforeAction($action);
            } else {
                echo 'Invalid page [USER_NOT-LOGGED-IN]'.$login_link;
                exit;
            }   
        } 

        if ($this->action->id == 'login') {
            // Check: SiteController.php
            if (!$access_granted) {
                return parent::beforeAction($action);
            }
            
            // if (empty(Yii::app()->user->isGuest)) {
            //     echo '<script>setTimeout(function() { location.href="' . Yii::app()->request->baseUrl . '/site/login"; }, 1000)</script> Redirecting to login page...';
            //     return;
            // }
        }        
        
    }

    
}