<?php

class DialogController extends Controller
{


    public $layout='//layouts/column_dialog';
    
    /**
     * Used for Redactor Upload
     * https://www.yiiframework.com/extension/redactor#usage
     * https://github.com/zxbodya/yii-redactor-upload-action
    */
    // public function actions()
    // {
    //     return array(
    //         'imgUpload' => array(
    //             'class' => 'ext.redactor.RedactorUploadAction',
    //             'saveCallback' => array($this, 'ImageUpload'),
    //             'validator' => array(
    //                 'mimeTypes' => array('image/png', 'image/jpg', 'image/gif', 'image/jpeg', 'image/pjpeg'),
    //             )
    //         ),
    //     );
    // }

    /**
     * Dialog: Action Item 
     */
    public function actionAction_item() 
    {   
        if(isset($_POST['ActionItem'])) {
            foreach($_POST['ActionItem'] as $key => $value) {
                $model = ActionItem::model()->findByPk($value['id']);
                if ($model==null) {
                    $model = new ActionItem;
                }
                $model->action_type_code = $value['action_type_code'];
                $model->description = $value['description'];
                $model->account_id = Yii::app()->session['account_id'];
                $model->customer_id = Yii::app()->session['customer_id'];
                $model->owner = '--';
                $model->created_date = date('Y-m-d');
                if (!$model->validate()) {
                    $this->renderJSON($model->getErrors());
                }
                $model->save();
            }
            $this->renderJSON(array(
                'status'=>'success', 
                'json'=>'Record saved'
            ));
        }
        
        $model = new ActionItem;
        
        $criteria=new CDbCriteria;
        $criteria->condition="account_id=:account_id AND customer_id=:customer_id";
        $criteria->params=array(
            ':account_id'=>Yii::app()->session['account_id'],
            ':customer_id'=>Yii::app()->session['customer_id'],
        );
        $action_item = ActionItem::model()->findAll($criteria);
        
        $this->render('action_item', array('model'=>$model, 'action_item'=>$action_item));
    }
    
    /**
     * Dialog: Add Note
     */
    public function actionAdd_note() 
    {   
        if(isset($_POST['Note'])) {
            foreach($_POST['Note'] as $key => $value) {
                $model = Note::model()->findByPk($value['id']);
                if ($model==null) {
                    $model = new Note;
                }
                $model->setAttributes(array(
                    'customer_id' => Yii::app()->session['customer_id'],
                    'account_id' => Yii::app()->session['account_id'],
                    'page_url' => $value['page_url'],
                    'msg_note' => $value['msg_note'],
                    'dom_element' => $value['dom_element'],
                    'created_at' => date('Y-m-d')
                ));
                if (!$model->validate()) {
                    $this->renderJSON($model->getErrors());
                }
                $model->save();
            }
            $this->renderJSON(array(
                'status'=>'success', 
                'json'=>'Record saved'
            ));
        }
        
        $model = new Note;
        
        $criteria=new CDbCriteria;
        if(isset($_GET['dom_element'])) {
            $criteria->condition="account_id=:account_id AND customer_id=:customer_id AND page_url = :page_url AND dom_element = :dom_element";
            $criteria->params=array(
                ':account_id'=>Yii::app()->session['account_id'],
                ':customer_id'=>Yii::app()->session['customer_id'],
                ':page_url'=>(isset($_GET['url'])) ? $_GET['url'] : '',
                ':dom_element'=>(isset($_GET['dom_element'])) ? $_GET['dom_element'] : '',
            );            
        } else {
            $criteria->condition="account_id=:account_id AND customer_id=:customer_id AND page_url = :page_url";
            $criteria->params=array(
                ':account_id'=>Yii::app()->session['account_id'],
                ':customer_id'=>Yii::app()->session['customer_id'],
                ':page_url'=>(isset($_GET['url'])) ? $_GET['url'] : ''
            );   
        }
        $note = Note::model()->findAll($criteria);
        
        $this->render('note', array('model'=>$model, 'note'=>$note));
    }
    
    /**
     * Dialog: Goals And Concerns
     */
    public function actionGoals_concerns()
    {
        if(isset($_POST['GoalsConcern'])) {
            foreach($_POST['GoalsConcern'] as $key => $value) {
                $model = GoalsConcern::model()->findByPk($value['id']);
                if ($model==null) {
                    $model = new GoalsConcern;
                }
                $model->action_type = $value['action_type'];
                $model->action_description = $value['action_description'];
                $model->account_id = Yii::app()->session['account_id'];
                $model->customer_id = Yii::app()->session['customer_id'];
                if (!$model->validate()) {
                    $this->dd($model->getErrors());
                }
                $model->save();
            }
            $this->dd(array(
                'status'=>'success', 
                'json'=>'Record saved'
            ));
        }
        
        $model = new GoalsConcern;
        
        $criteria=new CDbCriteria;
        $criteria->condition="account_id=:account_id AND customer_id=:customer_id";
        $criteria->params=array(
            ':account_id'=>Yii::app()->session['account_id'],
            ':customer_id'=>Yii::app()->session['customer_id'],
        );
        $goals_concerns = GoalsConcern::model()->findAll($criteria);
        
        $this->render('goals_concerns', array('model'=>$model, 'goals_concerns'=>$goals_concerns));
    }
    
    /**
     * Dialog: New Staff Form
     */
    public function actionNewstaff()
    {    
        // Form
        $criteria=new CDbCriteria;
        $criteria->condition="account_id=:account_id";
        $criteria->params=array(
            ':account_id'=>Yii::app()->session['account_id'],
        );
        
        $this->render('newstaff', array(
            'model'=>new Staff(), 
            'staff'=>Staff::model()->findAll($criteria),
            'security_group'=>SecurityGroup::model()->findAll($criteria),
        ));
    }
    
    /**
     * Dialog: Edit Staff Form
     */
    public function actionEditstaff($id)
    {        
        // Form
        $criteria=new CDbCriteria;
        $criteria->condition="account_id=:account_id";
        $criteria->params=array(
            ':account_id'=>Yii::app()->session['account_id'],
        );
        $this->render('updatestaff', array(
            'model'=>Staff::model()->findByPk($id), 
            'staff'=>Staff::model()->findAll($criteria),
            'security_group'=>SecurityGroup::model()->findAll($criteria),
        ));
    }
    
    /**
     * Dialog: New Security Group Form
     */
    public function actionNewsecuritygroup()
    {
        // Form
        $criteria=new CDbCriteria;
        $criteria->condition="account_id=:account_id";
        $criteria->params=array(
            ':account_id'=>Yii::app()->session['account_id'],
        );
        $this->render('newsecuritygroup', array(
            'model'=>new SecurityGroup(), 
            'securitygroup'=>SecurityGroup::model()->findAll($criteria)
        ));
    }
    
    /**
     * Dialog: Edit Security Group Form
     */
    public function actionEditsecuritygroup($id)
    {
        // Form
        $criteria=new CDbCriteria;
        $criteria->condition="account_id=:account_id";
        $criteria->params=array(
            ':account_id'=>Yii::app()->session['account_id'],
        );
        $this->render('updatesecuritygroup', array(
            'model'=>SecurityGroup::model()->findByPk($id),
            'securitygroup'=>SecurityGroup::model()->findAll($criteria)
        ));
    }
    
    /**
     * Dialog: Set Permission
     */
    public function actionSetpermission($id=null)
    {
        if ($id != null) {
            
            // for display
            $records = ProgramPermission::model()->findAll('account_id = :acct_id AND security_group_id = :sec_id', array(
                ':acct_id'=>Yii::app()->session['account_id'],
                ':sec_id'=>$id,
            ));

            // Form            
            $model = new ProgramPermission();
            
            $this->render('setpermission', array(
                'model'=>$model,
                'permitted'=>$records,
                'sec_id'=>$id,
            ));
        }
    }
    
    /**
     * Dialog: Credit Card Settings
     */
    public function actionCreditcardsettings()
    {
//         $data['itemno'] = time();
//         $data['itemname'] = 'subscription fee';
//         $data['itemdesc'] = 'coverage insights - subscription';
//         $data['qty'] = 1;
//         $data['amount'] = 39.99;
        
//         $payment = ANETFacade::save_transaction('1503129886', '1502487480', $data);
//         echo json_encode($payment);
//         exit;
        
        // Form
        $criteria=new CDbCriteria;
        $criteria->condition="account_id=:account_id";
        $criteria->params=array(
            ':account_id'=>Yii::app()->session['account_id'],
        );
        
        $model = new CreditCardForm();
        
        $records = CreditCardSettings::model()->findAll($criteria);

        $creditcardsettings = array();
        if(!empty($records)) {
            foreach($records as $k=>$v)
            {
                $cc_settings = ANETFacade::get_customer_profile($v->cim_customer_profile_id);
                //echo json_encode($cc_settings->xml->profile->paymentProfiles->payment->creditCard->expirationDate[0]);
                if ($cc_settings->isOk()) {
                    array_push($creditcardsettings, array(
                        'id'=>$v->id,
                        'is_primary'=>$v->is_primary,
                        'card_type'=>$v->card_type,
                        'credit_card'=>$cc_settings->xml->profile->paymentProfiles->payment->creditCard->cardNumber,
                        'expiry'=>$cc_settings->xml->profile->paymentProfiles->payment->creditCard->expirationDate[0],
                        'cim_customer_profile_id'=>$v->cim_customer_profile_id,
                        'created_at'=>$v->created_at,
                        'cim_payment_profile_id'=>$v->cim_payment_profile_id,
                    ));
                }
            }
        }
        
        $this->render('creditcardsettings', array(
            'model'=>$model,
            'creditcardsettings'=>$creditcardsettings,
        ));
    }
    
    
    /**
     * Dialog: New Email Template
     */
    public function actionNewemail_template()
    {
        Yii::import('ext.redactor.ImperaviRedactorWidget');
        
        // Form
        $criteria=new CDbCriteria;
        $criteria->condition="account_id=:account_id";
        $criteria->params=array(
            ':account_id'=>Yii::app()->session['account_id'],
        );
        $this->render('newemailtemplate', array(
            'model'=>new EmailTemplate(),
            'emailtemplate'=>EmailTemplate::model()->findAll($criteria)
        ));
    }
    
    /**
     * Dialog: Edit Email Template
     */
    public function actionEditemail_template($id=null)
    {
        Yii::import('ext.redactor.ImperaviRedactorWidget');
        
        if ($id != null) {
            
            // for display
            $records = EmailTemplate::model()->find('account_id = :acct_id AND id = :id', array(
                ':acct_id'=>Yii::app()->session['account_id'],
                ':id'=>$id,
            ));
                        
            $this->render('updateemailtemplate', array(
                'model'=>$records,
                'emailtemplate'=>$records,
                'id'=>$id,
            ));
        }
    }

    /**
     * Dialog: Send Credit Form
     */
    public function actionSendcredit()
    {
        $model = GiftCards::model()->find('account_id=:account_id', array(
            ':account_id'=>Yii::app()->session['account_id']
        ));
        $this->render('sendcredit', array(
            'model'=>$model,
            'refer_email'=>isset($_POST['refer_email']) ? $_POST['refer_email'] : '',
            'refer_id'=>isset($_POST['refer_id']) ? $_POST['refer_id'] : '',
        ));
    }

    
}