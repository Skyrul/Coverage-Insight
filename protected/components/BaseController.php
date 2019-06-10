<?php
class BaseController extends CController {

    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = '//layouts/column1';

    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = array();

    public $breadcrumbs = array();

    /* dynamic changing of page_label */
    public $page_label = '';
    
    /* top left content */
    public $top_left_content = '';
    
    /* dynamic actions buttons in header */
    public $action_buttons = array();

    /* dynamic with_progressbar */
    public $with_progressbar = false;
    public $progress_bar = array();

    /* footer collapseable menu */
    public $menu_collapsed = 'goto-sub-collapse';
    
    /* footer menu container */
    public $with_footer_menu = '';
    
    /* footer goto menu */
    public $goto_menu = true;
    
    

    /**
     * Return data to browser as JSON and end application.
     * @param array $data
     */
    protected function renderJSON($data) {
        header('Content-type: application/json');
        echo CJSON::encode($data);
        
        foreach (Yii::app()->log->routes as $route) {
            if ($route instanceof CWebLogRoute) {
                $route->enabled = false; // disable any weblogroutes
            }
        }
        Yii::app()->end();
    }
    
    /**
     * Return data to browser as JSON and end application.
     * @param array $data
     */
    protected function dd($data) {
        header('Content-type: application/json');
        echo CJSON::encode($data);
        
        foreach (Yii::app()->log->routes as $route) {
            if ($route instanceof CWebLogRoute) {
                $route->enabled = false; // disable any weblogroutes
            }
        }
        Yii::app()->end();
    }
    
    /**
     * Return data to browser as JSON.
     * @param array $data
     */
    protected function returnJSON($data) {
        //header('Content-type: application/json');
        echo CJSON::encode($data);
    }
    
    /**
     * Save activity data from Any part of application
     * @param string $action_key
     * @param array $data
     */
    protected function saveActivity($action_key, $data, $exist_delete= true) {
        if ($exist_delete) {
            $criteria = new CDbCriteria;
            $criteria->condition = "account_id=:account_id AND customer_id=:customer_id AND meta_key = :meta_key";
            $criteria->params=array(
                ':account_id'=>Yii::app()->session['account_id'],
                ':customer_id'=>Yii::app()->session['customer_id'],
                ':meta_key'=>$action_key
            );
            ActivityMeta::model()->deleteAll($criteria);
        }
        
        $model = new ActivityMeta;
        $model->account_id = Yii::app()->session['account_id'];
        $model->customer_id = Yii::app()->session['customer_id'];
        $model->meta_key = $action_key;
        $model->meta_value = $data;
        $model->save();
    }
    
    /**
     * Load activity data from Any part of application
     * @param string $action_id
     * @param array $data
     */
    protected function loadActivity() {
        $criteria = new CDbCriteria;
        $criteria->condition = "account_id = :account_id AND customer_id = :customer_id";
        $criteria->params = array(
            ':account_id' => Yii::app()->session['account_id'],
            ':customer_id' => Yii::app()->session['customer_id'],
        );
        $model = ActivityMeta::model()->findAll($criteria);
        if (!empty($model)) {
            echo "var hlt_data = [];\n";
            foreach ($model as $k => $v) {
                $vl = explode(':', $v->meta_key);
                echo 'hlt_data["' . $v->meta_key . '"] = JSON.parse(' . CJSON::encode($v->meta_value) . "); \n";
            }
            echo "global_config.hlt_data = hlt_data;\n";

            // Remote support
            // $alink = 'engagex-'. base64_encode(Yii::app()->session['account_id'] . "-" . Yii::app()->session['customer_id']);
            // $remotesupport = Yii::app()->params['remotesupport'] . $alink;
            // echo "global_config.remotesupport = '". $remotesupport ."';\n";
        }
    }
    
    /**
     * Get Email Template Based on Code
    */
    protected function getMailTemplate($code = '') {
        if ($code == '') { return null; }

        $model = EmailTemplate::model()->find('account_id=:account_id AND code=:code', array(
            ':account_id' => Yii::app()->session['account_id'],
            ':code' => $code,
        ));
        if ($model != null) {
            // From
            $from = $model->from;
            $from_name = $from;
            $bcc = "";

            // Subject
            $subject = $model->subject;

            // Email Message Content
            //$msgs = $model->html_head . $model->html_body;
            $preview_url = $this->programURL() . '/emailpreview/preview?id='. $model->id . '&secret=engagex';
            $emailcontent = file_get_contents($preview_url);

            return array(
                'from'=>$from,
                'from_name'=>$from_name,
                'subject'=> $subject,
                'emailcontent'=> $emailcontent,
            );
        } else {
            return null;
        }
    }

    public function standardSmartTagsReplace($combined) {
        $application_name = Yii::app()->name;
        $user_email = '';
        $user_name = '';
        $curdate = date('m/d/Y');
        $curdatetime = date('m/d/Y h:i:s a');
        
        $acct = AccountSetup::model()->find('id = :account_id', array(
            ':account_id'=>Yii::app()->session['account_id']
        ));
        if ($acct != null) {
            $user_email = $acct->email;
            $user_name = $acct->first_name . ' ' . $acct->last_name;
        }
        // Smart Tags
        // [application_name] = this append web application name
        // [curdate] = this append/display current date
        // [user_email] = this append/display the current loggedin user email
        // [user_name] = this append/display the current loggedin user full name
        // [curdatetime] = this append/display current date/time
        $combined = str_replace('[application_name]', $application_name, $combined);
        $combined = str_replace('[curdate]', $curdate, $combined);
        $combined = str_replace('[user_email]', $user_email, $combined);
        $combined = str_replace('[user_name]', $user_name, $combined);
        $combined = str_replace('[curdatetime]', $curdatetime, $combined);
        $combined = str_replace('[agency_logo]', '<img src="'. $this->applicationLogo(EnumLogo::CLIENT) .'">', $combined);
        return $combined;
    }

    /**
     * Send email
     */
    protected function sendMail($info) {
        $allowed = array(
            'from',
            'from_name',
            'sent_to',
            'sent_name',
            'subject',
            'bodytext',
            'bodyhtml',
            'attachment'
        );
        
        foreach ($info as $key => $value) {
            if (!in_array($key, $allowed))
                throw new CException('Your array field are invalid.');
        }

        $smtp_type = 'system'; // init

        $cr = new CDbCriteria;
        $cr->condition = "id = :account_id";
        $cr->params = array(':account_id' => Yii::app()->session['account_id']);
        $acct = EmailForm::model()->find($cr);
        if ($acct != null) {
            $config = array(
                'ssl' => 'tls',
                'port' => ($acct['smtp_password'] == null) ? '25' : $acct['smtp_port'],
                'auth' => 'login',
                'host'=> $acct['smtp_server'],
                'username' => $acct['smtp_username'],
                'password' => ($acct->smtp_type == 'gmail') ? self::security_decrypt($acct['smtp_password']) : $acct['smtp_password'],
            );
            $config['password'] = trim($config['password'], "\n"); 
            $config['password'] = trim($config['password'], " ");
            $config['password'] = trim($config['password'], "\0");
            $config['password'] = trim($config['password'], "\t");
            $config['password'] = trim($config['password'], "\x0B");
            $config['password'] = (string)$config['password'];

            // [DEBUG]
            // echo $config['password'];
            // echo '<br>';
            // echo strlen($config['password']);
            // $this->dd($config);
            // exit;
            
            $smtp_type = $acct->smtp_type;
        }
        
        // If no logged-in use the System default settings
        if (!isset(Yii::app()->session['account_id'])) {
            $smtp_type = 'system';
        }

        // If settings is system use the default settings
        if ($smtp_type == 'system') {
            $config = array(
                'ssl' => 'tls',
                'host'=> Yii::app()->params['adminSMTPHost'],
                'port' => Yii::app()->params['adminSMTPPort'],
                'auth' => 'login',
                'username' => Yii::app()->params['adminSMTPEmail'],
                'password' => Yii::app()->params['adminSMTPPassword'],
            );
            ini_set("SMTP", 'localhost');
            ini_set("smtp_port", $config['port']);
            ini_set("sendmail_from", $config['username']);
        } else {
            // If not setting config transport object
            // Transport Object
            $transport = new Zend_Mail_Transport_Smtp($config['host'], $config);
        }
        
        // DEBUG
        // $this->dd($config);
        // $this->dd($info);


        // #REGION: Based on default mail setting
            // From (Dont delete this logic, examine carefully)
            $from = ($smtp_type == '' || $smtp_type == 'system') ? Yii::app()->params['adminEmail'] : $config['username'];
            if (isset($info['from'])) {
                if ($info['from'] == ''){
                    $from = Yii::app()->params['adminEmail'];
                } else {
                    $from = $info['from'];
                }
            }
            $from_name = $from;

            // Send to
            $sent_to = strtolower($info['sent_to']);
            $sent_name = $info['sent_name'];
            
            // Subject
            $subject = $info['subject'];

            // Email Message Content
            if (isset($info['bodyhtml'])) {
                $emailcontent = $info['bodyhtml'];
            } else {
                if (isset($info['bodytext'])) {
                    $emailcontent = $info['bodytext'];
                }
            }
        // #ENDREGION        

        // #REGION: Compose email
        $mail = new Zend_Mail('utf-8');
        $mail->setHeaderEncoding(Zend_Mime::ENCODING_QUOTEDPRINTABLE);
        $mail->addTo($sent_to, $sent_name);
        $mail->setFrom($from, $from_name);
        $mail->setSubject($subject);
        $mail->setBodyHtml($emailcontent);
        // #ENDREGION

        try {
            if (isset($info['attachment'])) {
                $content = file_get_contents($info['attachment']);
                $attachment = new Zend_Mime_Part($content);
                $attachment->type = 'application/pdf';
                $attachment->disposition = Zend_Mime::DISPOSITION_ATTACHMENT;
                $attachment->encoding = Zend_Mime::ENCODING_BASE64;
                $attachment->filename = basename($info['attachment']);
                $mail->addAttachment($attachment);
            }
            
            if ($smtp_type == 'system') {
                $mail->send();
            }else {
                $mail->send($transport);
            }
            return true;
        } catch (Exception $e) {
            throw new CException('Error occured, email not sent.');
        }
    }

    /**
     * Send icvs (calendar meeting invitation)
    */
    protected function sendIcalEvent($from_name, $from_address, $to_name, $to_address, $startTime, $endTime, $subject, $description, $location)
    {
        $domain = 'exchangecore.com';
    
        //Create Email Headers
        $mime_boundary = "----Meeting Booking----".MD5(TIME());
    
        $headers = "From: ".$from_name." <".$from_address.">\n";
        $headers .= "Reply-To: ".$from_name." <".$from_address.">\n";
        $headers .= "MIME-Version: 1.0\n";
        $headers .= "Content-Type: multipart/alternative; boundary=\"$mime_boundary\"\n";
        $headers .= "Content-class: urn:content-classes:calendarmessage\n";
        
        //Create Email Body (HTML)
        $message = "--$mime_boundary\r\n";
        $message .= "Content-Type: text/html; charset=UTF-8\n";
        $message .= "Content-Transfer-Encoding: 8bit\n\n";
        $message .= "<html>\n";
        $message .= "<body>\n";
        $message .= '<p>Dear '.$to_name.',</p>';
        $message .= '<p>'.$description.'</p>';
        $message .= "</body>\n";
        $message .= "</html>\n";
        $message .= "--$mime_boundary\r\n";
    
        $ical = 'BEGIN:VCALENDAR' . "\r\n" .
        'PRODID:-//Microsoft Corporation//Outlook 10.0 MIMEDIR//EN' . "\r\n" .
        'VERSION:2.0' . "\r\n" .
        'METHOD:REQUEST' . "\r\n" .
        'BEGIN:VTIMEZONE' . "\r\n" .
        'TZID:Eastern Time' . "\r\n" .
        'BEGIN:STANDARD' . "\r\n" .
        'DTSTART:20091101T020000' . "\r\n" .
        'RRULE:FREQ=YEARLY;INTERVAL=1;BYDAY=1SU;BYMONTH=11' . "\r\n" .
        'TZOFFSETFROM:-0400' . "\r\n" .
        'TZOFFSETTO:-0500' . "\r\n" .
        'TZNAME:EST' . "\r\n" .
        'END:STANDARD' . "\r\n" .
        'BEGIN:DAYLIGHT' . "\r\n" .
        'DTSTART:20090301T020000' . "\r\n" .
        'RRULE:FREQ=YEARLY;INTERVAL=1;BYDAY=2SU;BYMONTH=3' . "\r\n" .
        'TZOFFSETFROM:-0500' . "\r\n" .
        'TZOFFSETTO:-0400' . "\r\n" .
        'TZNAME:EDST' . "\r\n" .
        'END:DAYLIGHT' . "\r\n" .
        'END:VTIMEZONE' . "\r\n" .	
        'BEGIN:VEVENT' . "\r\n" .
        'ORGANIZER;CN="'.$from_name.'":MAILTO:'.$from_address. "\r\n" .
        'ATTENDEE;CN="'.$to_name.'";ROLE=REQ-PARTICIPANT;RSVP=TRUE:MAILTO:'.$to_address. "\r\n" .
        'LAST-MODIFIED:' . date("Ymd\TGis") . "\r\n" .
        'UID:'.date("Ymd\TGis", strtotime($startTime)).rand()."@".$domain."\r\n" .
        'DTSTAMP:'.date("Ymd\TGis"). "\r\n" .
        'DTSTART;TZID="Eastern Time":'.date("Ymd\THis", strtotime($startTime)). "\r\n" .
        'DTEND;TZID="Eastern Time":'.date("Ymd\THis", strtotime($endTime)). "\r\n" .
        'TRANSP:OPAQUE'. "\r\n" .
        'SEQUENCE:1'. "\r\n" .
        'SUMMARY:' . $subject . "\r\n" .
        'LOCATION:' . $location . "\r\n" .
        'CLASS:PUBLIC'. "\r\n" .
        'PRIORITY:5'. "\r\n" .
        'BEGIN:VALARM' . "\r\n" .
        'TRIGGER:-PT15M' . "\r\n" .
        'ACTION:DISPLAY' . "\r\n" .
        'DESCRIPTION:Reminder' . "\r\n" .
        'END:VALARM' . "\r\n" .
        'END:VEVENT'. "\r\n" .
        'END:VCALENDAR'. "\r\n";
        $message .= 'Content-Type: text/calendar;name="meeting.ics";method=REQUEST'."\n";
        $message .= "Content-Transfer-Encoding: 8bit\n\n";
        $message .= $ical;
    
        $mailsent = mail($to_address, $subject, $message, $headers);
    
        return ($mailsent)?(true):(false);
    }

    
    /**
     * Return Application Set Logo, if null return default image
     */
    protected function applicationLogo($path = EnumLogo::SYSTEM_DEFAULT) {
        $dir = $this->programUrl();
        $main_logo = $dir . '/images/company.png';
        
        if ($path == EnumLogo::SYSTEM_DEFAULT):
            return $main_logo;
        else:
        $model = AccountSetup::model()->findByPk(Yii::app()->session['account_id']);
        if ($model != null) {
            if ($model->logo == null) {
                return $main_logo;
            }
            elseif($model->logo !== '') {
                // Cloudinary
                $cl = json_decode($model->logo);
                $a = $cl->secure_url;
                $secure_url = str_replace('image/upload/', 'image/upload/'. Yii::app()->params['cl_transformation'] . '/', $a);
                $secure_url = str_replace('.jpg', '.png', $secure_url);
                return $secure_url;
            } else {
                return $main_logo;
            }
        } else {
            return $main_logo;
        }
        endif;
    }

    /**
     * Return Agency Logo based on Customer Record
     */
    protected function getLogo($action = '', $criteria = '') {

        if ($action != '' && $criteria != '') {
            $account_id = null;
            if ($action == 'verification_code') {
                $videoconference = Videoconference::model()->find('verification_code=:verification_code', array(
                    ':verification_code'=>$criteria
                ));
                if ($videoconference != null) {
                    $account_id = $videoconference->account_id;
                }
            } 
            else if ($action == 'customer_id') {
                $customer = Customer::model()->find('id=:customer_id', array(
                    ':customer_id'=>$criteria
                ));
                if ($customer != null) {
                    $account_id = $customer->account_id;
                }
            }

            if ($account_id != null) {
                $model = AccountSetup::model()->find('id=:account_id', array(
                    ':account_id'=>$account_id
                ));
                if ($model != null) {
                    // echo __LINE__;
                    // echo '<br>' . $model->logo;
                    // exit;
                    if ($model->logo == null || $model->logo == '') {
                        return $this->programURL() . '/images/company.png';
                    }
                    else if($model->logo != '') {
                        // Cloudinary
                        $cl = json_decode($model->logo);
                        $a = $cl->secure_url;
                        $secure_url = str_replace('image/upload/', 'image/upload/'. Yii::app()->params['cl_transformation'] . '/', $a);
                        $secure_url = str_replace('.jpg', '.png', $secure_url);
                        return $secure_url;
                    }
                } // END: account_setup
            } // END: customer
        }
    }

    /**
     * Return Account ID based on verification code
     */
    protected function getAccountIDByVerification($verification_code = '') {
        $account_id = null;
        if ($verification_code != '') {
            $videoconference = Videoconference::model()->find('verification_code=:verification_code', array(
                ':verification_code'=>$verification_code
            ));
            if ($videoconference != null) {
                return $videoconference->account_id;
            }
        }
        return $account_id;
    }
    
    /**
     *  Return application colour
     */
    protected function applicationColour() {
        $scheme_id=0;
        $model = AccountSetup::model()->findByPk(Yii::app()->session['account_id']);
        if ($model != null) {
            if ($model->colour_scheme_id == null || $model->colour_scheme_id == 0) {
                $scheme_id = 1;
            } else {
                $scheme_id = $model->colour_scheme_id;
            }
            $customres = ColourScheme::model()->findByPk($scheme_id);
            if ($customres != null)
            {
                if($customres->scheme_name == 'Custom') {
                    // If its Custom browse custom table
                    return array(
                        'id' => $model->colour_scheme_id,
                        'theme' => ColourCustom::model()->find('account_id=:account_id', array(':account_id'=>Yii::app()->session['account_id']))
                    );
                } else {
                    return array(
                        'id' => $model->colour_scheme_id,
                        'theme' => $customres
                    );
                }
            }
        }
    }
    
    /**
     * Return program URL
     */
    protected function programURL() {
        if (!empty($_SERVER['HTTPS']) || isset($_SERVER['HTTPS'])) {
            $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
        } else {
            $protocol = 'http';
        }
        return $protocol . "://" . $_SERVER['HTTP_HOST'];
    }
    
    function normalize_path($path) {
        $path = str_replace( '\\', '/', $path );
        $path = preg_replace( '|(?<=.)/+|', '/', $path );
        if ( ':' === substr( $path, 1, 1 ) ) {
            $path = ucfirst( $path );
        }
        return $path;
    }
    
    /**
     * Store user activity on database
     * @param array $data
     */
    protected function logText($msg) {
        $model = new AuditLogs;
        $model->created_at = new CDbExpression('NOW()');
        $model->account = $msg;
        $model->page_url = $this->getCurrentURL();
        $model->posted_by = Yii::app()->user->name;
        $model->save();
    }
    
    /**
     * Return Current URL in Full (with or without paramaters)
     *
     * @return string $data
     */
    protected function getCurrentURL()
    {
        $currentURL = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
        $currentURL .= $_SERVER["SERVER_NAME"];
        
        if($_SERVER["SERVER_PORT"] != "80" && $_SERVER["SERVER_PORT"] != "443")
        {
            $currentURL .= ":".$_SERVER["SERVER_PORT"];
        }
        
        $currentURL .= $_SERVER["REQUEST_URI"];
        return $currentURL;
    }
    
    /**
     * Return if current string starts-with text criteria
     *
     * @return boolean $data
     */
    protected function startsWith($haystack, $needle) {
        // search backwards starting from haystack length characters from the end
        return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== false;
    }
    
    /**
     * Return if current string ends-with text criteria
     *
     * @return boolean $data
     */
    protected function endsWith($haystack, $needle) {
        // search forward starting from end minus needle length characters
        return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== false);
    }
    
    /**
     * Return if current account ROLE (Admin[Agent], Staff)
     */
    protected function currentUserRole()
    {
        $model = User::model()->find('email=:email AND account_id=:account_id', array(
            ':email'=>Yii::app()->user->name,
            ':account_id'=>Yii::app()->session['account_id']
        ));
        if($model!=null) {
            return $model->roles;
        }
    }
    
    /**
     * Returns the mask string of Credit Card
     * **/
    protected function ccMasking($cc, $maskFrom = 0, $maskTo = 4, $maskChar = 'x', $maskSpacer = '-')
    {
        // Clean out
        $cc       = str_replace(array('-', ' '), '', $cc);
        $ccLength = strlen($cc);
        
        // Mask CC number
        if (empty($maskFrom) && $maskTo == $ccLength) {
            $cc = str_repeat($maskChar, $ccLength);
        } else {
            $cc = substr($cc, 0, $maskFrom) . str_repeat($maskChar, $ccLength - $maskFrom - $maskTo) . substr($cc, -1 * $maskTo);
        }
        
        // Format
        if ($ccLength > 4) {
            $newCreditCard = substr($cc, -4);
            for ($i = $ccLength - 5; $i >= 0; $i--) {
                // If on the fourth character add the mask char
                if ((($i + 1) - $ccLength) % 4 == 0) {
                    $newCreditCard = $maskSpacer . $newCreditCard;
                }
                
                // Add the current character to the new credit card
                $newCreditCard = $cc[$i] . $newCreditCard;
            }
        } else {
            $newCreditCard = $cc;
        }
        
        return $newCreditCard;
    }
    
    protected function creditcardHide($cc)
    {
        return 'XXXX XXXX XXXX '.substr($cc,-4);
    }
    
    protected function numberPad($input, $padding, $c = "0")
    {
        return str_pad($input, $padding, $c, STR_PAD_LEFT);
    }
    
    protected function security_encrypt($plain_text)
    {
        $sec = new Helper();
        return $sec->encrypt($plain_text);
    }
    
    protected function security_decrypt($enc_text)
    {
        $sec = new Helper();
        return $sec->decrypt($enc_text);
    }

    protected function is_superuser()
    {
        $usr = User::model()->find("account_id = :acct_id AND superuser = '1'", array(
            ':acct_id'=>Yii::app()->session['account_id'],
        ));
        
        if ($usr != null) {
            return true;
        }
        return false;
    }
    
    protected function is_admin()
    {
        if (Yii::app()->user->roles == EnumRoles::ADMINISTRATOR) {
            return true;
        }
        return false;
    }
    
    protected function is_staff()
    {
        if (Yii::app()->user->roles == EnumRoles::STAFF) {
            return true;
        }
        return false;
    }
    
    protected  function errors2string($errors)
    {
        $err_msg = array();
        foreach($errors as $k=>$v) {
            array_push($err_msg, '* '.$v[0]);
        }
        return implode('<br>',$err_msg);
    }
}
