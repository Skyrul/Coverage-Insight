<?php
class SetupController extends Controller 
{
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    public function accessRules() {
        return array(
            array('allow',
                'actions' => array(
                    'update_info',
                    'update_logo',
                    'remove_logo',
                    'update_resource',
                    'remove_resource',
                    'update_resource_custom_label',
                    'update_email',
                    'update_password',
                    'update_listing',
                    'update_colour',
                    'updatecustom_colour',
                    'reset_colour',
                    'update_policies',
                    'delete_policy',
                    'bill_payment',
                    'cancel_account',
                ),
                'roles'=>array('admin', 'staff'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionUpdate_info() {
        $updated = false;

        $model = new InfoForm;
        if (isset($_POST['InfoForm'])) {
            $model->attributes = $_POST['InfoForm'];
            if ($model->validate()) {
                // tbl_account_setup
                $cmd = Yii::app()->db->createCommand();
                $cmd->update(
                        'tbl_account_setup', array(
                            'first_name' => $model->first_name,
                            'last_name' => $model->last_name,
                            // email must be readonly
                            'office_phone_number' => $model->office_phone_number,
                            'agency_name' => $model->agency_name,
                            'timezone' => $model->timezone,
                        ), 'id = :account_id', array(
                            ':account_id' => Yii::app()->session['account_id'],
                        )
                );
                $updated = true;
            }
        }

        if ($updated) {
            //Yii::app()->user->setFlash('success', 'Information updated');
            $this->dd(array('status'=>'success', 'json'=> 'Information updated'));
        } else {
            $err_text = preg_replace("/\r|\n/", "", CHtml::errorSummary($model, '', '') );
            $err_text = str_replace('errorSummary', '', $err_text);
            //Yii::app()->user->setFlash('error', $err_text);
            $this->dd(array('status'=>'error', 'json'=> $err_text));
        }
        $this->redirect(array('/account/setup#info'));
    }

    public function actionUpdate_logo()
    {
        if (isset($_POST['json'])) {
            try {
                $cmd = Yii::app()->db->createCommand();
                $cmd->update(
                    'tbl_account_setup', array(
                        'logo' => $_POST['json']
                    ),
                    'id=:account_id', array(
                        ':account_id' => Yii::app()->session['account_id']
                    )
                 );
                $this->dd(array('status'=>'success', 'json'=>'Image Updated'));
            } catch (Exception $e) {
                $this->dd(array('status'=>'error', 'json'=>'Error occured on your request'));
            }
        }
    }
    
    public function actionUpdate_logo_________________() {
        //$dir = Yii::getPathOfAlias('application.uploads');
        $dir = Yii::app()->basePath . '/../uploads';
        $uploaded = false;

        $model = new LogoForm();
        if (isset($_POST['LogoForm'])) {
            $model->attributes = $_POST['LogoForm'];
            $model->logo = CUploadedFile::getInstance($model, 'logo');
            if ($model->validate()) {
                $new_img_name = md5($model->logo->getName()) . '.' . pathinfo($model->logo->getName(), PATHINFO_EXTENSION
                );
                $uploaded = $model->logo->saveAs(
                        $dir . '/' . $new_img_name
                );

                // update database if file uploaded
                if ($uploaded) {
                    $cmd = Yii::app()->db->createCommand();
                    $cmd->update(
                            'tbl_account_setup', array(
                        'logo' => $new_img_name
                            ), 'id=:account_id', array(
                        ':account_id' => Yii::app()->session['account_id']
                            )
                    );
                }
            }
        }

        if ($uploaded) {
            Yii::app()->user->setFlash('success', 'Image updated');
        } else {
            $err_text = preg_replace("/\r|\n/", "", CHtml::errorSummary($model, '', '') );
            $err_text = str_replace('errorSummary', '', $err_text);
            Yii::app()->user->setFlash('error', $err_text);
        }
        $this->redirect(array('/account/setup'));
    }

    public function actionRemove_logo() {
        $model = new LogoForm();
        if (isset($_POST['LogoForm'])) {
            $cmd = Yii::app()->db->createCommand();
            $cmd->update(
                    'tbl_account_setup', array(
                'logo' => null
                    ), 'id=:account_id', array(
                ':account_id' => Yii::app()->session['account_id']
                    )
            );

            Yii::app()->user->setFlash('success', 'Logo removed');
            $this->redirect(array('/account/setup'));
        }
    }
    
    public function actionUpdate_resource($insurance_type = '-')
    {
        if (isset($_POST['json'])) {
            try {
                $model = new ClientResources;
                $model->insurance_type = $insurance_type;
                $model->json = $_POST['json'];
                $model->created_at = new CDbExpression('NOW()');
                $model->account_id = Yii::app()->session['account_id'];
                $model->posted_by = Yii::app()->user->name;
                $model->save();
                $this->dd(array('status'=>'success', 'json'=>'Resource Uploaded'));
            } catch (Exception $e) {
                $this->dd(array('status'=>'error', 'json'=>'Error occured on your request'));
            }
        }
    }
    
    public function actionRemove_resource($id = 0) {
            try {
                ClientResources::model()->deleteAll('account_id = :account_id AND id = :id', array(':account_id'=>Yii::app()->session['account_id'], ':id'=>$id));
                $this->dd(array('status'=>'success', 'json'=>'Resource item removed'));
            } catch (Exception $e) {
                $this->dd(array('status'=>'error', 'json'=>'Error occured on your request'));
            }
    }

    public function actionUpdate_resource_custom_label($id = 0) {
        if (isset($_POST['ClientResource'])) {
            try {
                $model = ClientResources::model()->find('account_id = :account_id AND id = :id', array(':account_id'=>Yii::app()->session['account_id'], ':id'=>$id));
                if ($model != null) {
                    $model->custom_label = $_POST['ClientResource']['custom_label'];
                    $model->save();
                }
                $this->dd(array('status'=>'success', 'json'=>'Resource Label Updated'));
            } catch (Exception $e) {
                $this->dd(array('status'=>'error', 'json'=>'Error occured on your request'));
            }
        }
    }
    
    public function actionUpdate_password() {
        $updated = false;

        $model = new PasswordForm();
        if (isset($_POST['PasswordForm'])) {
            $model->attributes = $_POST['PasswordForm'];
            if ($model->validate()) {
                $cmd = Yii::app()->db->createCommand();
                // tbl_account_setup
                $cmd->update('tbl_account_setup', array(
                            'password' => $this->security_encrypt($model->password)
                        ), 'id = :account_id', array(
                            ':account_id' => Yii::app()->session['account_id']
                        )
                );
                // tbl_user
                $cmd->update('tbl_user', array(
                    'password' => $this->security_encrypt($model->password)
                        ), 'email=:email', array(
                    ':email' => Yii::app()->user->name
                        )
                );
                $updated = true;
            }
        }

        if ($updated) {
            Yii::app()->user->setFlash('success', 'Password Updated!');
        } else {
            $err_text = preg_replace("/\r|\n/", "", CHtml::errorSummary($model, '', '') );
            $err_text = str_replace('errorSummary', '', $err_text);
            Yii::app()->user->setFlash('error', $err_text);
        }
        $this->redirect(array('/account/setup'));
    }

    public function actionUpdate_email() {
        $updated = false;

        $model = new EmailForm();
        if (isset($_POST['EmailForm'])) {
            $model->attributes = $_POST['EmailForm'];
            if ($model->validate()) {
                $cmd = Yii::app()->db->createCommand();
                // tbl_account_setup
                $cmd->update('tbl_account_setup', array(
                            'smtp_type' => $model->smtp_type,
                            'smtp_server' => $model->smtp_server,
                            'smtp_username' => $model->smtp_username,
                            'smtp_password' => $this->security_encrypt($model->smtp_password),
                            'smtp_port' => $model->smtp_port,
                        ), 'id = :account_id', array(
                            ':account_id' => Yii::app()->session['account_id']
                        )
                );
                $updated = true;
            }
        }

        if ($updated) {
            Yii::app()->user->setFlash('success', 'Email Updated!');
        } else {
            $err_text = preg_replace("/\r|\n/", "", CHtml::errorSummary($model, '', '') );
            $err_text = str_replace('errorSummary', '', $err_text);
            Yii::app()->user->setFlash('error', $err_text);
        }
        //$this->redirect(array('/account/setup#email'));
        $this->redirect($this->programURL() . '/account/setup?cache='. time() . '#email');
    }

    public function actionUpdate_listing() {
        $model = new ListingForm();
        if (isset($_POST['ListingForm'])) {
            $model->attributes = $_POST['ListingForm'];
            // tbl_account_setup
            $cmd = Yii::app()->db->createCommand();
            $cmd->update(
                    'tbl_account_setup', array(
                        'apointment_locations' => $model->apointment_locations,
                        'staff' => $model->staff
                    ), 'id=:account_id', array(
                        ':account_id' => Yii::app()->session['account_id']
                    )
            );

//             Yii::app()->user->setFlash('success', 'Lists updated');
//             $this->redirect(array('/account/setup#listing'));
            $this->dd(array('status'=>'success', 'json'=> 'Lists updated'));
        }
    }

    public function actionUpdate_colour() {
        $model = new ColourForm();
        if (isset($_POST['ColourForm'])) {
            $model->attributes = $_POST['ColourForm'];
            // tbl_account_setup
            $cmd = Yii::app()->db->createCommand();
            $cmd->update(
                    'tbl_account_setup', array(
                        'colour_scheme_id' => $model->colour_scheme_id,
                    ), 'id=:account_id', array(
                        ':account_id' => Yii::app()->session['account_id']
                    )
            );
            
            if (isset($_POST['ColourForm'])) {
                $scheme = ColourScheme::model()->find('id=:id', array(':id'=>$model->colour_scheme_id));
                
                $model = ColourCustom::model()->find('account_id = :account_id', array(':account_id' => Yii::app()->session['account_id']));
                if ($model == null) {
                    $model = new ColourCustom();
                }
                $model->color_1 = $scheme->color_1;
                $model->color_2 = $scheme->color_2;
                $model->color_3 = $scheme->color_3;
                $model->color_4 = $scheme->color_4;
                $model->color_5 = $scheme->color_5;
                $model->color_6 = $scheme->color_6;
                $model->account_id = Yii::app()->session['account_id'];
                $model->save();
            }
            
            $this->dd(array('status'=>'success', 'json'=> 'Color scheme updated'));
        }
    }


    public function actionUpdateCustom_colour() 
    {
        if (isset($_POST['CustomColor'])):
            $acct = AccountSetup::model()->findByAttributes(array('id' => Yii::app()->session['account_id']));
            if ($acct != null) {
                $acct->colour_scheme_id = $_POST['CustomColor']['scheme_id'];
                $acct->save();
            }
            
            //$model = ColourScheme::model()->findByAttributes(array('scheme_name' => 'Custom'));
            if (isset($_POST['CustomColor'])) {
                $model = ColourCustom::model()->find('account_id = :account_id', array(':account_id' => Yii::app()->session['account_id']));
                if ($model == null) {
                    $model = new ColourCustom();
                }
                $model->color_1 = $_POST['CustomColor']['color_1'];
                $model->color_2 = $_POST['CustomColor']['color_2'];
                $model->color_3 = $_POST['CustomColor']['color_3'];
                $model->color_4 = $_POST['CustomColor']['color_4'];
                $model->color_5 = $_POST['CustomColor']['color_5'];
                $model->color_6 = $_POST['CustomColor']['color_6'];
                $model->account_id = Yii::app()->session['account_id'];
                $model->save();
                $this->renderJSON(array('status' => 'success', 'json' => 'Color updated'));
            }
        endif;
    }

    public function actionReset_colour() 
    {
        if (isset($_POST['ColourForm'])) {
            // tbl_account_setup
            $cmd = Yii::app()->db->createCommand();
            $cmd->update(
                    'tbl_account_setup', array(
                'colour_scheme_id' => 1,
                    ), 'id=:account_id', array(
                ':account_id' => Yii::app()->session['account_id']
                    )
            );

            Yii::app()->user->setFlash('success', 'Colour Theme resetted');
            $this->redirect(array('/account/setup#colour'));
        }
    }

    public function actionUpdate_policies() {
        if (!isset($_GET['insurance_type'])) {
            echo 'No insurance type specified';
            exit;
        }

        $insurance_type = $_GET['insurance_type'];

        // transaction connection
        $connection = Yii::app()->db;
        $connection->active = true;
        $transaction = $connection->beginTransaction();
        try {
            // [DEBUG]
            // $this->renderJSON($_POST['PoliciesForm']);
            if (isset($_POST['PoliciesForm'])) {

                // delete existing record
                $sql1 = "DELETE FROM tbl_account_setup_policy WHERE account_id=:account_id AND policy_parent_label=:label";
                $connection->createCommand($sql1)->execute(array(
                    ':account_id' => Yii::app()->session['account_id'],
                    ':label' => $insurance_type
                ));

                if (isset($_POST['PoliciesForm'][$insurance_type . '_count'])) {
                    $count = $_POST['PoliciesForm'][$insurance_type . '_count'];
                    for ($i = 1; $i <= $count; $i++) {
                        $parent_chk = 'ParentChk_' . $insurance_type;
                        $child_chk = 'ChildChk_' . $insurance_type . '-' . $i;
                        $child_text = 'ChildText_' . $insurance_type . '-' . $i;
                        $child_value = 'ChildValue_' . $insurance_type . '-' . $i;
                        // parent check
                        if (isset($_POST['PoliciesForm'][$parent_chk])) {
                            if ($_POST['PoliciesForm'][$parent_chk] == "on") {
                                $parent_chk = 1;
                            } else {
                                $parent_chk = 0;
                            }
                        } else {
                            $parent_chk = 0;
                        }
                        // child check
                        if (isset($_POST['PoliciesForm'][$child_chk])) {
                            if ($_POST['PoliciesForm'][$child_chk] == "on") {
                                $child_chk = 1;
                            } else {
                                $child_chk = 0;
                            }
                        } else {
                            $child_chk = 0;
                        }

                        // update status of check marked
                        $sql2 = "UPDATE tbl_account_setup SET is_" . $insurance_type . "_checked = :is_checked WHERE id = :account_id";
                        $connection->createCommand($sql2)->execute(array(
                            ':is_checked' => $parent_chk,
                            ':account_id' => Yii::app()->session['account_id']
                        ));

                        // insert new policy
                        $sql3 = "INSERT INTO tbl_account_setup_policy (policy_parent_label, policy_child_label, policy_child_questions, policy_child_values, is_child_checked, account_id) ";
                        $sql3 .= "VALUES (:policy_parent_label, :policy_child_label, :policy_child_questions, :policy_child_values, :is_child_checked, :account_id)";
                        $connection->createCommand($sql3)->execute(
                                array(
                                    'policy_parent_label' => $insurance_type,
                                    'policy_child_label' => $_POST['PoliciesForm'][$child_text],
                                    'policy_child_questions' => $_POST['PoliciesForm'][$child_text],
                                    'policy_child_values' => $_POST['PoliciesForm'][$child_value],
                                    'is_child_checked' => $child_chk,
                                    'account_id' => Yii::app()->session['account_id'],
                                )
                        );
                    } // endforeach;
                } // end-isset-auto


                $transaction->commit();
                $this->renderJSON(array(
                    'status' => 'success',
                    'json' => 'Policies updated',
                ));
            } // end-policies
        } catch (Exception $e) { // an exception is raised if a query fails
            $transaction->rollback();
            $this->renderJSON(array(
                'status' => 'error',
                'json' => 'Something wrong with the request, rollback..',
            ));
        }
        $connection->active = false;
    }

    public function actionDelete_policy() {
        $connection = Yii::app()->db;

        $connection->active = true;
        $transaction = $connection->beginTransaction();
        try {
            if (isset($_POST['id'])) {
                // delete existing record
                $sql1 = "DELETE FROM tbl_account_setup_policy WHERE account_id=:account_id AND id=:id";
                $connection->createCommand($sql1)->execute(array(
                    ':account_id' => Yii::app()->session['account_id'],
                    ':id' => $_POST['id']
                ));

                $transaction->commit();
                $this->renderJSON(array(
                    'status' => 'success',
                    'json' => 'Policies deleted',
                ));
            }
        } catch (Exception $e) { // an exception is raised if a query fails
            $transaction->rollback();
            $this->renderJSON(array(
                'status' => 'error',
                'json' => 'Something wrong with the request, rollback..',
            ));
        }
        $connection->active = false;
    }
    
    
    /**
     * Billing payment
     */
    public function actionBill_payment()
    {        
        $not_ok_url = '/account/setup?billstatus=notok#billing';
        $ok_url     = '/account/setup?billstatus=ok#billing';
        
        if (isset($_POST['BillingForm'])):
            $form = $_POST['BillingForm'];
            
            // validate
            $model = new BillingForm();
            $model->attributes = $form;
            $model->account_id = Yii::app()->session['account_id'];
            $model->description = "-";
            $model->status = "-";
            if (!$model->validate()) {
                $msg = $this->errors2string($model->getErrors());
                Yii::app()->user->setFlash('error', $msg);
                $this->redirect($not_ok_url);
            }
            
            // init variable
            $enroll_fee = $staff_fee  = $total_bill = $promo_amount = 0;
            $promo_code = '';
            $chargesfee = ChargesFacade::fees();
            
            $invoice_type = $form['invoice_type'];   // what kind of invoice is it
            $description  = '';
            
            
            $acct_setup = AccountSetup::model()->find('id = :account_id', array(
                ':account_id'=>Yii::app()->session['account_id']
            ));

            if (isset($form['invoice_type']) && $acct_setup != null):
            
                // ** bill computation **

                // enrollment invoice
                if ($invoice_type == EnumStatus::ENROLLMENT) {
                    // invoice number
                    $invoice_num = time();
                    
                    $enroll_fee  = $chargesfee->enrollment_fee;
                    $total_bill = $enroll_fee;
                    $description = "Enrollment Fee";
                }
            
                // monthly invoice
                if ($invoice_type == EnumStatus::SUBSCRIPTION) {
                    // invoice number
                    $invoice_num = $form['invoice_no'];
                    
                    $enroll_fee  = $chargesfee->enrollment_fee;
                    $total_bill = $enroll_fee;
                    $description = "Subscription Fee";
                }
                
                // buy staff only
                if ($invoice_type == EnumStatus::BUYSTAFF) {
                    // invoice number
                    $invoice_num = time();
                    
                    $staff_fee   = $chargesfee->staff_fee;
                    $total_bill  = $staff_fee;
                    $description = "Staff Fee";
                    
                    // save staff credits
                    $staff_credits = new StaffCredits();
                    $staff_credits->account_id   = $acct_setup->id;
                    $staff_credits->staff_credit = $chargesfee->staff_credits;
                    $staff_credits->created_at   = new CDbExpression('NOW()');
                    $staff_credits->save();
                }

                // gift cards orders
                $gc_total = BillingFacade::giftcard_order_total();
                if ($gc_total > 0) {
                    $description =  $description . " + Giftcards Orders (Virtual-Incentives)";
                    $total_bill = $total_bill + $gc_total;
                }

                // promo deduction
                if (isset($form['promo_code']) && $form['promo_code'] != '') {
                    $promo = Promo::model()->find('promo_code = :promo_code', array(
                        ':promo_code'=>$form['promo_code']
                    ));
                    if($promo != null) {
                        $promo_code   = $promo->promo_code;
                        $promo_amount = $promo->amount_off;
    
                        $description .= " (Promo Off: ". $promo_amount .")";
                        $total_bill  = $total_bill - $promo_amount;
                    }
                }
                
                // get CIM information
                $customer_profile_id='';
                $payment_profile_id='';
                $cc = CreditCardSettings::model()->find('id = :id AND account_id = :account_id', array(
                    ':id'=>$form['credit_card'],
                    ':account_id'=>Yii::app()->session['account_id'],
                ));
                if ($cc != null) {
                    $customer_profile_id = $cc->cim_customer_profile_id;
                    $payment_profile_id  = $cc->cim_payment_profile_id;
                    $cim = ANETFacade::get_customer_payment_profile($customer_profile_id, $payment_profile_id);
                } else {
                    Yii::app()->user->setFlash('billerror', 'Error getting customer profile');
                }
                
                if (isset($cim)) {
                    
                    // compose transaction
                    $data['amount'] = $total_bill;
                    $data['itemno'] = $invoice_num;
                    $data['itemname'] = $invoice_type;
                    $data['itemdesc'] = $description;
                    $data['cc_cardnum'] = $cc->credit_card;
                    $data['qty'] = 1;
                    
                    
                    // payment processing
                    $transaction = ANETFacade::save_transaction($cc->cim_customer_profile_id, $cc->cim_payment_profile_id, $data);                    
                    if ($transaction['status'] != EnumStatus::SUCCESS) {
                        Yii::app()->user->setFlash('billerror', $transaction['msg']);
                    } else {                        
                        // transaction id
                        $transaction_id = $transaction['transaction_id'];

                        // record payments
                        $payment = new Payments();
                        $payment->account_id               = $acct_setup->id;
                        $payment->created_at               = new CDbExpression("NOW()");
                        $payment->invoice_type             = $invoice_type;
                        $payment->invoice_number           = $invoice_num;
                        $payment->enrollment_fee           = $enroll_fee;
                        $payment->staff_fee                = $staff_fee;
                        $payment->promo_code               = $promo_code;
                        $payment->promo_off                = $promo_amount;
                        $payment->invoice_total            = $total_bill;
                        $payment->payment_date             = new CDbExpression("NOW()");
                        $payment->invoice_description      = $description;
                        $payment->creditcard               = $data['cc_cardnum'];
                        $payment->anet_customer_profile_id = $customer_profile_id;
                        $payment->anet_payment_profile_id  = $payment_profile_id;
                        $payment->anet_transaction_id      = $transaction_id;
                        if ($payment->save()) {
                            // Update Billing
                            $billing = Billing::model()->find('bill_no = :bill_no', array(
                                ':bill_no'=>$invoice_num
                            ));
                            if ($billing != null) {
                                $billing->bill_status = EnumStatus::PAID;
                                $billing->update();
                            }
                            // Remove Lockout
                            $lock_acct = LockAccount::model()->delete('account_id = :account_id', array(
                                ':account_id'=>Yii::app()->session['account_id'],
                            ));
                            // Mark Gift Cards Orders Paid
                            $update = Yii::app()->db->createCommand()->update('tbl_referral_gc', 
                                array(
                                    'status'=>EnumStatus::PAID,
                                    'anet_transaction_id'=> $transaction_id,
                                ),
                                'account_id=:account_id',
                                array(
                                    ':account_id'=>Yii::app()->session['account_id']
                                )
                            );
                            // Place order in Virtual Incentives
                            $referral = ReferralGC::model()->findAll('account_id=:account_id AND (not anet_transaction_id IS null) AND order_json IS null', array(
                                ':account_id'=>Yii::app()->session['account_id']
                            ));
                            if (!empty($referral)) {
                                foreach($referral as $k => $v) {
                                    
                                }
                            }
                        } else {
                            $msg = $this->errors2string($payment->getErrors());
                            Yii::app()->user->setFlash('billerror', $msg);
                        }
                    }
                }
                
                
                
            endif;  // check invoice type

            if(Yii::app()->user->hasFlash('billerror')) {
                // $this->dd(Yii::app()->user->getFlash('billerror'));
                // back page
                $this->redirect($not_ok_url);
            } else {
                // success page
                $this->redirect($ok_url);
            }
            
            
        endif; // check if BillingForm exists
    }
    

    public function actionCancel_account()
    {
        $acct = BillingFacade::next_billing();
        if ($acct == '') {
            $model = new CancelledAccount();
            $model->account_id = Yii::app()->session['account_id'];
            $model->created_at = new CDbExpression('NOW()');
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Account is now cancelled');
                $this->redirect($this->programURL());
            }
        } else {
            Yii::app()->user->setFlash('error', 'Sorry, You still have some pending invoice');
            $this->redirect($this->programURL().'/account/setup');
        }
    }
    
}
