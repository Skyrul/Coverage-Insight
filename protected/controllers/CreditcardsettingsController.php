<?php
class CreditCardSettingsController extends Controller 
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
                    'save',
                    'update',
                    'delete',
                    'setdefault',
                ),
                'roles' => array(EnumRoles::ADMINISTRATOR, EnumRoles::STAFF),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Save Credit Card
     * */
    public function actionSave()
    {
        if(isset($_POST['CreditCardForm']))
        {
            $form = $_POST['CreditCardForm'];
            $model = new CreditCardForm;
            $model->attributes = $form;
            $model->account_id = Yii::app()->session['account_id'];
            $model->created_at = new CDbExpression('NOW()');
            if ($model->validate()) { 
                
                // account setup
                $acct_setup = AccountSetup::model()->find('id = :account_id', array(
                    ':account_id'=>Yii::app()->session['account_id'],
                ));
                
                // add new customer profile in CIM
                $cim = ANETFacade::save_customer_profile(array(
                    'description'=>Yii::app()->name,
                    'card_num'=>$form['cc_number'],
                    'exp_date'=>$form['cc_expiry_month'].'/'.$form['cc_expiry_year'],
                    'email'=>$acct_setup->email,
                    'bill_address'=>$form['address'],
                    'bill_state'=>$form['state'],
                    'bill_city'=>$form['city'],
                    'bill_zipcode'=>$form['zip'],
                    'bill_phone'=>'',
                ));
                
                if ($cim['status'] == EnumStatus::ERROR) {
                    $this->dd(array(
                        'status'=>'error',
                        'json'=>$cim['msg'],
                    ));
                } else {
                    $customer_profile_id = $cim['customerProfileId'];
                    $payment_profile_id  = $cim['paymentProfileId'];
                    
                    // insert summary data in db
                    $insert = new CreditCardSettings();
                    $insert->account_id              = Yii::app()->session['account_id'];
                    $insert->created_at              = new CDbExpression('NOW()');
                    $insert->credit_card             = $form['cc_number'];
                    $insert->card_type               = $form['card_type'];
                    $insert->cim_customer_profile_id = $customer_profile_id;
                    $insert->cim_payment_profile_id  = $payment_profile_id;
                    if(!$insert->save()) {
                        $this->dd(array(
                            'status'=>'error',
                            'json'=>$insert->errors,
                        ));
                    }
                    
                    $this->dd(array(
                        'status'=>'success',
                        'json'=>'Record saved'
                    ));
                }
                
            } else {
                $this->dd(array(
                    'status'=>'error',
                    'json'=>CHtml::errorSummary($model, '','')
                ));
            }
        }
    }
    
    
    /**
     * Update Credit Card
     * */
    public function actionUpdate()
    {
        if(isset($_POST['CreditCardForm']))
        {
            // Edit
            $form = $_POST['CreditCardForm'];
            if (isset($form['id'])) {
                $model = CreditCardSettings::model()->findByPk($form['id']);
                if ($model != null)
                {
                    $model->group_name = $form['group_name'];
                    $model->status = $form['status'];
                    if ($model->validate()) {
                        $model->save();
                        $this->dd(array(
                            'status'=>'success',
                            'json'=>'Record Update'
                        ));
                    } else {
                        $this->dd(array(
                            'status'=>'error',
                            'json'=>CHtml::errorSummary($model, '','')
                        ));
                    }
                }
            }
        }
    }
    
    /**
     * Delete Credit Card
     */
    public function actionDelete()
    {
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $cc = CreditCardSettings::model()->find('account_id=:account_id AND id=:id', array(
                ':account_id'=>Yii::app()->session['account_id'],
                ':id'=>$id,
            ));
            if($cc != null) {
                
                // delete cim record
                $cim1 = ANETFacade::delete_customer_profile($cc->cim_customer_profile_id);
                $cim2 = ANETFacade::delete_customer_profile($cc->cim_customer_profile_id, $cc->cim_payment_profile_id);
                
                if ($cim1['status'] == 'error') {
                    $this->dd(array(
                        'status'=>'error',
                        'json'=>$cim1['msg'],
                    ));
                }
               
                
                if ($cim1['status'] == 'success') {
                    // delete the one on db
                    $cc->delete();
                    $this->dd(array(
                        'status'=>'success',
                        'json'=>'Record deleted'
                    ));
                }
                
            } else {
                $this->dd(array(
                    'status'=>'error',
                    'json'=>'Delete failed'
                ));
            }
        }
    }
    
    /**
     * Set Default Credit Card
     */
    public function actionSetdefault($id=0)
    {        
        // set selected to be primary
        $model = CreditCardSettings::model()->findByPk($id);
        if($model != null) {
            
            // set all to not_primary
            $criteria = new CDbCriteria;
            $criteria->addCondition( "account_id", Yii::app()->session['account_id'] );
            CreditCardSettings::model()->updateAll(array('is_primary'=>'0'), $criteria);
            
            // edit field
            $model->is_primary = 1;
            $model->save();
            
            $this->dd(array(
                'status'=>'success',
                'json'=>'Set successfully'
            ));
        } else {
            $this->dd(array(
                'status'=>'error',
                'json'=>'Delete failed'
            ));
        }
    }

}
