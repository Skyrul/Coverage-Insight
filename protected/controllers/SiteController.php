<?php

class SiteController extends Controller
{

    /**
     * Declares class-based actions.
     */
    public function actions()
    {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF
            )
        );
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionAccess()
    {
        if (! isset($_GET['id']) && ! isset($_GET['token'])) {
            die('Invalid access');
        }
        
        $customer_id = $_GET['id'];
        $guid_token = $_GET['token'];
        
        // get customer data
        $customer = Customer::model()->findByPk($customer_id);
        
        // get appointment
        $findctr = new CDbCriteria();
        $findctr->condition = "assessment_guid = :assessment_guid";
        $findctr->params = array(
            ':assessment_guid' => $guid_token
        );
        $appointment = Appointment::model()->find($customer_id);
        if ($appointment != null) {
            // check expiry of link
            // $timediff = strtotime('Now') - strtotime($appointment->created_at); // in seconds
            // if ($timediff > 3600) // exceed 1hour
            // {
            // die('Sorry this link is expired exceed 1 hour. Kindly request for new assessment');
            // }
            
            $model = new Customer();
            // validate post request
            if (isset($_POST['Customer'])) {
                $criteria = new CDbCriteria();
                $criteria->condition = "id = :id AND primary_telno = :telno";
                $criteria->params = array(
                    ':id' => $customer_id,
                    ':telno' => $_POST['Customer']['primary_telno']
                );
                $customer_verify = Customer::model()->find($criteria);
                if ($customer_verify != null) {
                    // store information to session
                    Yii::app()->session['account_id'] = $customer_verify->account_id;
                    Yii::app()->session['customer_id'] = $customer_id;
                    Yii::app()->session['assessment_guid'] = $guid_token;
                    Yii::app()->session['accessed_via_email'] = true;
                    Yii::app()->session['na_ok'] = true;
                    
                    Yii::app()->user->setFlash('success', 'Access Granted');
                    $this->redirect(array(
                        'needassessment/step_instructions'
                    ));
                } else {
                    Yii::app()->user->setFlash('error', 'Invalid customer or primary telephone number');
                }
            } // post
        }
        
        // change master page layout
        $this->layout = '//layouts/column_login';
        $this->render('access', array(
            'model' => $model,
            'customer' => $customer
        ));
    }

    public function actionIndex()
    {}

    // /**
    //  * This is the action to handle external exceptions.
    //  */
    // public function actionError()
    // {
    //     if ($error = Yii::app()->errorHandler->error) {
    //         if (Yii::app()->request->isAjaxRequest)
    //             echo $error['message'];
    //         else
    //             $this->render('error', $error);
    //     }
    // }

    /**
     * Activate new account
     */
    public function actionActivate($email = null)
    {
        if ($email != null) {
            $email = str_replace(' ', '+', $email);
            $criteria = new CDbCriteria();
            $criteria->condition = "email = :email";
            $criteria->params = array(
                ':email' => $email
            );
            if (AccountSetup::model()->exists($criteria)) {
                // flag account setup that this email is activated
                Yii::app()->user->setFlash('success', 'Account now activated. You can now login.');
                $cmd = Yii::app()->db->createCommand();
                $cmd->update('tbl_account_setup', array(
                    'is_activated' => 1
                ), 'email=:email', array(
                    ':email' => $email
                ));
                
                // update parent account user
                $account_setup = AccountSetup::model()->find($criteria);
                if ($account_setup != null) {
                    $cmd->update('tbl_user', array(
                        'account_id' => $account_setup->id
                    ), 'email=:email', array(
                        ':email' => $email
                    ));
                }
                $activated = true;
                
                // **** Default fields for account setup ***
                $dlt_ctr = 0;
                $cr = new CDbCriteria();
                $cr->condition = "email = :email";
                $cr->params = array(
                    ':email' => $email
                );
                $acct101 = AccountSetup::model()->find($cr);
                if ($acct101 != null) {
                    $fixedrec = array(
                        'Year',
                        'Make',
                        'Model'
                    );
                    foreach ($fixedrec as $k => $v) {
                        $dlt_ctr = $dlt_ctr + 1;
                        $yr = new AccountSetupPolicy();
                        $yr->policy_parent_label = 'Auto';
                        $yr->policy_child_label = $v;
                        $yr->policy_child_questions = $v;
                        $yr->is_child_checked = 1;
                        $yr->account_id = $acct101->id;
                        $yr->order_id = $dlt_ctr;
                        $yr->save();
                    }
                    
                    $auto_defaults = 'Liability,Uninsured Motorist,Medical,Comp/Collision,Roadside/Tow';
                    $fixedrec1 = explode(',', $auto_defaults);
                    foreach ($fixedrec1 as $k => $v) {
                        $dlt_ctr = $dlt_ctr + 1;
                        $r = new AccountSetupPolicy();
                        $r->policy_parent_label = 'Auto';
                        $r->policy_child_label = $v;
                        $r->policy_child_questions = $v;
                        $r->is_child_checked = 1;
                        $r->account_id = $acct101->id;
                        $r->order_id = $dlt_ctr;
                        $r->save();
                    }
                    
                    $home_defaults = 'Type, Coverage,Sep Structures,Contents,Additional Living,Liability,Guest Med';
                    $fixedrec2 = explode(',', $home_defaults);
                    foreach ($fixedrec2 as $k => $v) {
                        $dlt_ctr = $dlt_ctr + 1;
                        $r = new AccountSetupPolicy();
                        $r->policy_parent_label = 'Home';
                        $r->policy_child_label = $v;
                        $r->policy_child_questions = $v;
                        $r->is_child_checked = 1;
                        $r->account_id = $acct101->id;
                        $r->order_id = $dlt_ctr;
                        $r->save();
                    }
                }
                // END: **** Default fields for account setup ***
            } else {
                Yii::app()->user->setFlash('error', 'Email does not exists.');
            }
        }
        
        foreach (Yii::app()->user->getFlashes() as $key => $message) {
            echo '<h1 class="flash-' . $key . '">' . $message . "</h1>\n";
        }
        
        if (isset($activated)) {
            echo '<br><a href="/site/login">Click Here To Login</a>';
        }
        
        Yii::app()->end();
    }

    /**
     * Displays the create an account page
     */
    public function actionCreate_account()
    {

        // // Test
        // $customer_profile = ANETFacade::save_customer_profile(array(
        //     'description'=>Yii::app()->name,
        //     'card_num'=>'4242424242424242',
        //     'exp_date'=>'04/2019',
        //     'firstName'=>'Jim',
        //     'lastName'=>'Campbell',
        //     'email'=>'jim.campbell@engagex.com',
        //     'bill_address'=>'Test Address',
        //     'bill_state'=>'Test State',
        //     'bill_city'=>'Test City',
        //     'bill_zipcode'=>'Test Zipcode',
        //     'bill_phone'=>'36287773678',
        // ));
        // echo json_encode($customer_profile);
        // exit;

        $model = new CreateAccountForm();
        
        if (isset($_POST['CreateAccountForm'])) {
            $data = $_POST['CreateAccountForm'];
            
            $model->attributes = $data;
            
            $email = AccountSetup::model()->find("email = :email", array(
                ':email' => $data['email']
            ));
            if ($email != null) {
                Yii::app()->user->setFlash('error', 'Your email address already taken');
            } else {
                if ($model->validate()) {
                    // customer profile CIM
                    $customer_profile = ANETFacade::save_customer_profile(array(
                        'description'=>Yii::app()->name,
                        'card_num'=>$data['cc_cardnum'],
                        'exp_date'=>$data['cc_expiry_month'].'/'.$data['cc_expiry_year'],
                        'email'=>$data['email'],
                        'bill_address'=>$data['bill_address'],
                        'bill_state'=>$data['bill_state'],
                        'bill_city'=>$data['bill_city'],
                        'bill_zipcode'=>$data['bill_zipcode'],
                        'bill_phone'=>$data['bill_phone'],
                    ));
                    
                    if ($customer_profile['status'] == EnumStatus::ERROR) {
                        Yii::app()->user->setFlash('error', $customer_profile['msg']);
                    } else {
                        $customer_profile_id = $customer_profile['customerProfileId'];
                        $payment_profile_id  = $customer_profile['paymentProfileId'];
                        
                        
                        // save account setup
                        $acct_setup = new AccountSetup();
                        $acct_setup->email               = $data['email'];
                        $acct_setup->password            = $this->security_encrypt($data['password']);
                        $acct_setup->agency_name         = $data['agency_name'];
                        $acct_setup->first_name          = $data['first_name'];
                        $acct_setup->last_name           = $data['last_name'];
                        $fullname = $acct_setup->first_name . ' ' . $acct_setup->last_name; // combined
                        $acct_setup->office_phone_number = $data['bill_phone'];
                        $acct_setup->videoconf_feature = $data['videoconf_feature'];
                        if(!$acct_setup->save())
                        {
                            Yii::app()->user->setFlash('error', $acct_setup->errors);
                        }   else   {
                            // save login user
                            $username = explode('@', $acct_setup->email);
                            $user = new User();
                            $user->account_id = $acct_setup->id;
                            $user->email    = $acct_setup->email;
                            $user->username = $acct_setup->email;
                            $user->fullname = (isset($fullname) ? '-' : $fullname);
                            $user->password = $acct_setup->password;
                            $user->roles    = EnumRoles::ADMINISTRATOR;
                            if (!$user->save()) {
                                //$this->dd($user->errors);
                                Yii::app()->user->setFlash('error', 'Error saving user information');
                            }
                            
                            // save credit card information
                            $cc = new CreditCardSettings();
                            $cc->account_id = $acct_setup->id;
                            $cc->created_at = new CDbExpression('NOW()');
                            $cc->is_primary = 1;
                            $cc->cim_customer_profile_id = $customer_profile_id;
                            $cc->cim_payment_profile_id  = $payment_profile_id;
                            $cc->credit_card = $data['cc_cardnum'];
                            $cc->card_type = $data['cc_cardtype'];
                            if(!$cc->save()) {
                                //$this->dd($cc->errors);
                                Yii::app()->user->setFlash('error', 'Error saving card detail');
                            }
                            
                            
                            // init variable
                            $enroll_fee     = 0;
                            $staff_fee      = 0;
                            $videoconf_fee  = 0;
                            $total_bill     = 0;
                            $promo_amount   = 0;

                            $promo_code = '';
                            $chargesfee = ChargesFacade::fees();
                            
                            // bill computation
                            $enroll_fee  = $chargesfee->enrollment_fee;
                            $description = "Enrollment Fee";
                            $total_bill = $enroll_fee;

                            // IF user initially buy staff
                            if (boolval($data['buy_staff'])) {
                                $staff_fee   = $chargesfee->staff_fee;
                                $total_bill  = $total_bill + $staff_fee;
                                $description = $description . " + Staff Fee";
                                
                                // save staff credits
                                $staff_credits = new StaffCredits();
                                $staff_credits->account_id   = $acct_setup->id;
                                $staff_credits->staff_credit = $chargesfee->staff_credits;
                                $staff_credits->created_at   = new CDbExpression('NOW()');
                                $staff_credits->save();
                            }

                            // If user initially enable video conference feature
                            if (boolval($data['videoconf_feature'])) {
                                $videoconf_fee   = $chargesfee->videoconf_feature_fee;
                                $total_bill  = $total_bill + $videoconf_fee;
                                $description = $description . " + Video Conference Feature Fee";
                            }
                            
                            // promo deduction
                            if ($data['promo_code'] != '') {
                                $promo = Promo::model()->find('promo_code = :promo_code', array(
                                    ':promo_code'=>$data['promo_code']
                                ));
                                if($promo != null) {
                                    $promo_code   = $data['promo_code'];
                                    $promo_amount = $promo->amount_off;
                                    
                                    $description = $description . " (Promo Off: ". $promo_amount .")";
                                    $total_bill  = $total_bill - $promo_amount;
                                }
                            }
                            
                            // payment transaction
                            $invoice_num = date('Ym').'-'.$acct_setup->id;
                            $transaction = ANETFacade::save_payment(array(
                                'cust_id'     =>$customer_profile_id,
                                'last_name'   => $data['last_name'],
                                'first_name'   => $data['first_name'],
                                'company'     =>$acct_setup->agency_name,
                                'address'     =>$data['bill_address'],
                                'city'        =>$data['bill_city'],
                                'state'       => $data['bill_state'],
                                'zip'         => $data['bill_zipcode'],
                                'country'     => 'USA',
                                'phone'       => $data['bill_phone'],
                                'invoice_num' =>$invoice_num,
                                'amount'      =>$total_bill,
                                'card_num'    =>$data['cc_cardnum'],
                                'exp_date'    =>$data['cc_expiry_month'].'/'.$data['cc_expiry_year'],
                                'email'       =>$data['email'],
                                'description' =>$description,
                            ));
                            
                            if ($transaction['status'] == EnumStatus::ERROR) {
                                Yii::app()->user->setFlash('error', 'Error saving payment: '. $transaction['msg']);
                            } else {
                                $transaction_id = $transaction['transaction_id'];
                                
                                // record invoice
                                $inv = new Billing();
                                $inv->account_id  = $acct_setup->id;
                                $inv->created_at  = new CDbExpression("NOW()");
                                $inv->bill_type   = EnumStatus::ENROLLMENT;
                                $inv->bill_no     = $invoice_num;
                                $inv->fee         = $enroll_fee;
                                $inv->promo_code  = $promo_code;
                                $inv->promo_off   = $promo_amount;
                                $inv->bill_amount = $total_bill;
                                $inv->bill_status = EnumStatus::PAID;
                                $inv->save();
                                
                                // record payments 
                                $payment = new Payments();
                                $payment->account_id               = $acct_setup->id;
                                $payment->created_at               = new CDbExpression("NOW()");
                                $payment->invoice_number           = $invoice_num;
                                $payment->enrollment_fee           = $enroll_fee;
                                $payment->staff_fee                = $staff_fee;
                                $payment->videoconf_fee            = $videoconf_fee;
                                $payment->promo_code               = $promo_code;
                                $payment->promo_off                = $promo_amount;
                                $payment->invoice_total            = $total_bill;
                                $payment->payment_date             = new CDbExpression("NOW()");
                                $payment->invoice_description      = $description;
                                $payment->invoice_type             = EnumStatus::ENROLLMENT;
                                $payment->creditcard               = $data['cc_cardnum'];
                                $payment->anet_customer_profile_id = $customer_profile_id;
                                $payment->anet_payment_profile_id  = $payment_profile_id;
                                $payment->anet_transaction_id      = $transaction_id;
                                if (!$payment->save()) {
                                    //$this->dd($payment->errors);
                                    Yii::app()->user->setFlash('error', 'Error saving payment details');
                                }
                            }
                            
                            if(Yii::app()->user->hasFlash('error')) {
                                // back page
                                $this->redirect('/site/create_account');
                            } else {
                                // success page
                                $this->redirect('/site/success?email='.$acct_setup->email .'&ok=true');
                            }
                        }

                    }
                    


                } // validate $model
            } 
        }
        
        // change master page layout
        $this->layout = '//layouts/column_login';
        
        $this->render('create_account', array(
            'model' => $model
        ));
    }
    
    
    public function account_verification($email = '')
    {
        $email = str_replace(' ', '+', $email);
        $data = AccountSetup::model()->find('email = :email', array(':email'=>$email));
        if ($data != null) {
            
            // Compose Verification Link
            $verification_link = Yii::app()->createAbsoluteUrl('site/activate', array(
                'email' => $email
            ));
            $btnstyle = "border: 2px solid #104996;background-color: #0888ed;color:white;padding: 4px;padding-right: 18px;padding-left: 18px;font-size: 21px;text-decoration:none;";
            $html      = '<img src="'. $this->applicationLogo(EnumLogo::CLIENT) .'" style="width: 20%;"><br>';
            $html     .= "Dear " . $email . " (" . $data->agency_name . ")<br><br>" . "Please click the link below to confirm that this email address will be associated with your " . Yii::app()->name . " user account:<br><br>" . "<a href='" . $verification_link . "' style='". $btnstyle ."'>Verify this Email</a><p>&nbsp;</p>";
            $info = array(
                'sent_to' => $email,
                'sent_name' => 'New User',
                'subject' => Yii::app()->name . ' - Verify Email Account',
                'bodyhtml' => $html,
            );
            $sent = $this->sendMail($info);
            if ($sent) {
                return true;
            } else {
                echo 'Error on your email request';
                Yii::app()->end();
            }
        }
    }
    
    /**
     * Account Created
     */
    public function actionSuccess($email=null)
    {
        if($email != null) {
            $sent = false;
            $email = str_replace(' ', '+', $email);
            if (isset($_GET['resend'])) {
                $sent = self::account_verification($email);
                if ($sent) {
                    Yii::app()->user->setFlash('success', "Successfully RE-Sent Your Account Verification Link!");
                }
            } 
            else if(isset($_GET['ok'])) {
                $sent = self::account_verification($email);
                if ($sent) {
                    Yii::app()->user->setFlash('success', "Successfully Sent Your Account Verification Link!");
                }
            }
            else {
                echo 'Invalid';
                exit;
            }
            
            $this->renderPartial('success', array('email'=>CHtml::encode($email)));
        }
    }
    

    /**
     * Displays the login page
     */
    public function actionLogin()
    {
        $model = new LoginForm();
        
        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        
        // collect user input data
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->login()) {
                Yii::app()->session['access_granted'] = true;
                $this->redirect(Yii::app()->user->returnUrl);
            }
        }
        // change master page layout
        $this->layout = '//layouts/column_login';
        // display the login form
        $this->render('login', array(
            'model' => $model
        ));
    }

    /**
     * Display reset password page
     */
    public function actionReset_password($email = null, $hash = null)
    {
        if ($email != null && $hash != null) {
            // tweak email param
            $email = str_replace(' ', '+', $email);
            
            $criteria = new CDbCriteria();
            $criteria->condition = 'email = :email';
            $criteria->params = array(
                ':email' => $email
            );
            
            if (User::model()->exists($criteria)) {
                if (isset($_POST['User'])) {
                    $cmd = Yii::app()->db->createCommand();
                    $cmd->update('tbl_account_setup', array(
                        'password' => $this->security_encrypt($_POST['User']['password'])
                    ), 'email=:email', array(
                        ':email' => $email
                    ));
                    $cmd->update('tbl_user', array(
                        'password' => $this->security_encrypt($_POST['User']['password'])
                    ), 'email=:email', array(
                        ':email' => $email
                    ));
                    
                    Yii::app()->user->setFlash('success', 'Password successfully changed! (will auto-redirect in 1 second)');
                    echo '<script>setTimeout(function() { location.href="/site/login" }, 1000)</script>';
                }
                
                // change master page layout
                $this->layout = '//layouts/column_login';
                // display the login form
                $model = new User();
                $this->render('reset_password', array(
                    'model' => $model,
                    'email' => $email
                ));
            } else {
                echo 'Invalid request, or your account does not exists';
            }
        } else {
            $this->renderJSON('Invalid access');
        }
    }

    /**
     * Display the forgot password page
     */
    public function actionForgot_password()
    {
        $model = new User();
        
        if (isset($_POST['User'])) {
            
            $criteria = new CDbCriteria();
            $criteria->condition = 'email = :email';
            $criteria->params = array(
                ':email' => $_POST['User']['email']
            );
            
            if (AccountSetup::model()->exists($criteria)) {
                // seek and store to memory
                $model = AccountSetup::model()->find($criteria);
                
                $app_name = Yii::app()->name;
                $title = "Reset your " . Yii::app()->name . " password";
                $reset_expiration = date("Y-m-d H:i:s", strtotime('+1 hours'));
                $reset_link = Yii::app()->createAbsoluteUrl('site/reset_password', array(
                    'email' => $model->email,
                    'hash' => $this->security_encrypt($reset_expiration)
                ));
                $to = $model->email;
                $body = "Hi " . $to . ",<br><br>" . "You have recently asked to reset the password for this " . $app_name . " account<br>" . $to . "<br><br>To update your password, click the link below:" . "<br>" . $reset_link . "<br><br>" . "Cheers, <br><br>" . "Team " . $app_name . "<br><br>" . "NOTE: This password reset link will expire in 1 hour";
                
                if ($this->sendMail(array(
                    'sent_to' => $to,
                    'sent_name' => 'New User',
                    'subject' => $title,
                    'bodyhtml' => $body
                ))) {
                    Yii::app()->user->setFlash('success', 'Recovery email was sent to your inbox');
                }
            } else {
                Yii::app()->user->setFlash('error', 'Invalid request, or your account does not exists');
            }
        }
        
        // change master page layout
        $this->layout = '//layouts/column_login';
        // display the login form
        $this->render('forgot_password', array(
            'model' => $model
        ));
    }

    /**
     * Display the Staff verification page
     * */
    public function actionStaff_verification($email)
    {
        // change master page layout
        $this->layout = '//layouts/column_login';
        
        // tweak email param
        $email = str_replace(' ', '+', $email);
        
        // when save post
        if (isset($_POST['User'])) {
            $model = User::model()->find('email=:email AND roles=:roles', array(
                ':email'=>$email,
                ':roles'=>EnumRoles::STAFF,
            ));
            if ($model != null) {
                $model->username = $email;
                $model->password = $this->security_encrypt($_POST['User']['password']);
                $model->status=EnumStatus::ACTIVE;
                $model->update();
                $this->redirect('/site/staff_verified');
                exit;
            }
        }
        
        
        $model = User::model()->find('email=:email AND roles=:roles', array(
            ':email'=>$email,
            ':roles'=>EnumRoles::STAFF,
        ));
        if ($model != null) {
            if($model->status == EnumStatus::INACTIVE) {
                $setup = AccountSetup::model()->find('id=:account_id', array(':account_id'=>$model->account_id));
                $this->render('staff_verification', array('model'=>$model, 'setup'=>$setup));
            } else {
                $this->redirect('/site/staff_verified?completed=true');   
            }
        } else {
            echo 'Invalid access';
        }
    }
    
    public function actionStaff_verified()
    {
        // change master page layout
        $this->layout = '//layouts/column_login';
        $this->render('staff_verified');
    }
    
    public function actionCron()
    {
        self::runCron();
    }
    
    public function actionView_soa($billno ='00000')
    {
        $this->redirect($this->programURL() . '/reports/renderpdf?report_name=billing&report_tpl=billing&billno='. $billno);
    }
    
    public function actionTest_email()
    {
        $info = array(
            'sent_to' => 'db874196e6-0a12f7@inbox.mailtrap.io',
            'sent_name' => 'New User',
            'subject' => Yii::app()->name . ' - Verify Email Account',
            'bodyhtml' => '<h2>Test Email</h2>',
        );
        
        $sent = $this->sendMail($info);
        if ($sent){
            echo 'Sent';
        }
    }
    
    public function actionTest_security()
    {
        $enc = '';
        $decc = '';
        if (isset($_POST['Form1'])) {
            $text = $_POST['Form1']['text'];
            $enc = $this->security_encrypt($text);
        }
        
        if (isset($_POST['Form2'])) {
            $text = $_POST['Form2']['text'];
            $decc = $this->security_decrypt($text);
        }
        
        $this->renderPartial('test_security', array(
            'enc'=>$enc,
            'decc'=>$decc,
        ));
        
    }
    
    public function actionSuperuser($email = '')
    {
        $user = User::model()->find('email=:email', array(
            ':email'=>$email
        ));
        if ($user != null) {
            $user->superuser = 1;
            $user->save();
            
            echo 'done - '. $email . ' are now superuser';
            exit;
        }
    }
    
    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout()
    {
        // Check: Controller.php
        // Yii::app()->user->logout();
        // Yii::app()->session->clear();
        // $this->redirect(Yii::app()->homeUrl);
    }
    
    
    
}
