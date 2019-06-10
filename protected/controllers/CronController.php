<?php

class CronController extends Controller
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

    // **** Cron Jobs ****
    public function runCron()
    {
        
        // **************** SAVING BILLING *********************
        $acct_setup = AccountSetup::model()->findAll();
        if (!empty($acct_setup)) {
            foreach($acct_setup as $k=>$v) {
                
                $account_id = $v->id;

                $usr = User::model()->find("account_id = :account_id AND superuser = '0'", array(
                    ':account_id'=>$account_id,
                ));
                if ($usr != null) {
                    $account_created_date = $v->created_at; // this the date first registration
                    $start_date = null;
                    $promo_code = null;
                    $promo_off  = null;
                    
                    $criteria = new CDbCriteria();
                    $criteria->condition="account_id = :account_id";
                    $criteria->params=array(
                        ':account_id'=>$account_id,
                    );
                    
                    // when account is first created the billing table will be empty
                    $billing = Billing::model()->find('account_id = :account_id', array(
                        ':account_id'=>$account_id,
                    ));
                    if ($billing != null) {
                        $src = 'billing';
                        $start_date = $billing->next_billing;
                        if ($billing->promo_off > 0) {
                            $promo_code = $billing->promo_code;
                            $promo_off = $billing->promo_off;
                        }
                    } else {
                        $src = 'payment';
                        $criteria->condition="account_id = :account_id AND invoice_type IN ('". EnumStatus::ENROLLMENT ."', '". EnumStatus::SUBSCRIPTION ."')";
                        $criteria->params=array(
                            ':account_id'=>$account_id,
                        );
                        
                        // get previous payment date
                        $prev_payment = Payments::model()->find($criteria);
                        if ($prev_payment != null){
                            $start_date = $prev_payment->payment_date;
                            if ($prev_payment->promo_off > 0) {
                                $promo_code = $prev_payment->promo_code;
                                $promo_off = $prev_payment->promo_off;
                            }
                        } else {
                            // first creation date $account_setup
                            $start_date = $account_created_date;
                        }
                    }
                    
                    // current date
                    $current_date = date('Y-m-d');
                    
                    // $start_date is the last payment
                    $last_payment_date = $start_date;
                    
                    // next billing logic (add 1 month)
                    $add1month = strtotime('+1 month', strtotime($last_payment_date));
                    $next_billing = date('Y-m-d', $add1month);
                    
                    // $due_date is the $next_billing date
                    $due_date = $next_billing;
                    
                    // compute
                    $date1 = new DateTime($current_date);
                    $date2 = new DateTime($next_billing);
                    $days  = $date2->diff($date1)->format('%R%a');
                    $days  = floatval($days);
                    
                    // generate 10days range
                    $tendays = range(-1, -10);
                    $within_range = true; //in_array($days, $tendays);
                    
                    if (isset($_GET['test'])):
                        echo 'account_id: '. $account_id.'<br>';
                        echo 'current date: '. date('Y-m-d').'<br>';
                        echo 'last payment: '.$last_payment_date .'<br>';
                        echo 'next billing: '. $next_billing .'<br>';
                        echo 'days diff:'. $days .'<br>';
                        echo '<hr>';
                    endif;
                    
                    // if its within 10days it should save to billing
                    if ($within_range):
                        // generate bill number (Year and month only, exclude Day)
                        $bill_no = date('Ym', strtotime($next_billing)) . '-' . $account_id;
                        $bill_exists = Billing::model()->find('bill_no = :bill_no', array(
                            ':bill_no'=>$bill_no,
                        ));
                        if ($bill_exists == null) {
                            
                            // unique insert it in billing table
                            $bill = new Billing();
                            $bill->account_id  = $account_id;
                            $bill->bill_type   = EnumStatus::SUBSCRIPTION;
                            $bill->bill_no     = $bill_no;
                            $bill->fee         = ChargesFacade::fees()->enrollment_fee;
                            $ispromo_expired = PromoFacade::is_promo_expired($promo_code);
                            if ($ispromo_expired == false) {
                                $bill->promo_code = $promo_code;
                                $bill->promo_off = $promo_off;
                                $bill->bill_amount = $bill->fee - $promo_off;
                            } else {
                                $bill->bill_amount = $bill->fee;
                            }
                            $bill->bill_status = EnumStatus::UNPAID;
                            $bill->created_at = $current_date;  // this is the invoice date
                            $bill->next_billing = $next_billing;
                            $bill->due_date = $due_date;
                            if ($bill->save()) {
                                // locked account add user and the due date
                                $lock_b = LockAccount::model()->exists('account_id=:account_id', array(':account_id'=>$account_id));
                                if ($lock_b == false) {
                                    $lock_it = new LockAccount();
                                    $lock_it->account_id = $account_id;
                                    $lock_it->locked_date = $due_date;
                                    $lock_it->save();
                                }
                            } else {
                                $this->dd($bill->getErrors());
                            }
                        }
                    endif;
                } // Skip superuser                
            }
        }
        
        
        
        
        // ************************* SENDING INVOICE ************************************
        $number_email_sent = 0;
        if(isset($_GET['send_invoice'])):
            if (!empty($acct_setup)) {
                foreach($acct_setup as $k=>$v) {
                    // account
                    $account_id = $v->id;
                    $email      = $v->email;
                    
                    $soa = Billing::model()->find('account_id = :account_id AND bill_status=:status', array(
                        ':account_id'=>$account_id,
                        ':status'=>EnumStatus::UNPAID,
                    ));
                    if ($soa != null) {
                        $bill_no = $soa->bill_no;
                        $next_billing = date('Y-m-d', strtotime($soa->next_billing));
                        
                        // current date
                        $current_date = date('Y-m-d');
                        
                        // $due_date is the $next_billing date
                        $due_date = $next_billing;
                        
                        // compute
                        $date1 = new DateTime($current_date);
                        $date2 = new DateTime($next_billing);
                        $days  = $date2->diff($date1)->format('%R%a');
                        $days  = floatval($days);
                        
                        // generate 10days range
                        $tendays = range(-1, -10);
                        $within_range = in_array($days, $tendays);
                        
                        // start: check if within 10days
                        if ($within_range) {
                            $html = '';
                            $html .= '<img src="'. $this->applicationLogo(EnumLogo::SYSTEM_DEFAULT) .'" width="224px" /><br><br>';
                            $html .= 'Your <strong>'. Yii::app()->name .'</strong> account has a new invoice<br><br>';
                            // user need to login before viewing SOA
                            $html .= '<a href="'. $this->programURL() .'/site/view_soa?billno='. $bill_no .'">Invoice #'. $bill_no .'</a> / ('. abs($days) . ' days before due date)<br><br>';
                            // end of soa link
                            $html .= 'To view your billing statement and make a payment, please log into your client panel at '. $this->programURL() . '/account/setup#billing. <br><br>';
                            $html .= 'Thank you for choosing '. Yii::app()->name .'<br><br>';
                            $html .= '-- '. Yii::app()->name .' Support Team --<br><br>';
                            
                            if (isset($_GET['test'])) {
                                echo $html;
                                echo '<hr>';
                            } else {
                                $info = array(
                                    'sent_to'=>$email,
                                    'sent_name'=>'Agent',
                                    'subject'=>Yii::app()->name .':New Invoice',
                                    'bodyhtml'=>$html,
                                );
                                $this->sendMail($info);
                                
                                $number_email_sent++;
                            }
                        }
                        //end: check if within 10days
    
    
                    }
                }
            }
        endif;
        
        echo json_encode(array(
            'number_email_sent'=>$number_email_sent,
            'status'=>'success',
        ));
        exit;
        
    }

}