<?php
class EmailtemplateController extends Controller 
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
                    'preview',
                    'sendtest',
                ),
                'roles' => array(EnumRoles::ADMINISTRATOR, EnumRoles::STAFF),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Save
     * */
    public function actionSave()
    {
        if(isset($_POST['EmailTemplate']))
        {
            $form = $_POST['EmailTemplate'];
            $model = new EmailTemplate;
            $model->account_id = Yii::app()->session['account_id'];
            $model->code = $form['code'];
            $model->name = Yii::app()->session['account_id'];
            $model->format_type = ($form['format_type'] == '') ? EnumStatus::FIXED_LAYOUT : $form['format_type'];
            if ($model->validate()) {                
                $model->from = $form['from'];
                $model->subject = $form['subject'];
                $model->html_head = $form['html_head'];
                $model->html_body = $form['html_body'];
                $model->bg_image_url = $form['bg_image_url'];
                $model->save();
                $this->dd(array(
                    'status'=>'success',
                    'json'=>'Record saved'
                ));
                
            } else {
                $this->dd(array(
                    'status'=>'error',
                    'json'=>CHtml::errorSummary($model, '','')
                ));
            }
        }
    }
    
    
    /**
     * Update
     * */
    public function actionUpdate()
    {
        if(isset($_POST['EmailTemplate']))
        {
            // Edit
            $form = $_POST['EmailTemplate'];
            if (isset($form['id'])) {
                $model = EmailTemplate::model()->findByPk($form['id']);
                if ($model != null)
                {
                    $form = $_POST['EmailTemplate'];
                    $model = EmailTemplate::model()->find('account_id = :acct_id AND id = :id', array(
                        ':acct_id'=>Yii::app()->session['account_id'],
                        ':id'=>$form['id'],
                    ));
                    $model->account_id = Yii::app()->session['account_id'];
                    $model->code = $form['code'];
                    $model->name = Yii::app()->session['account_id'];
                    $model->format_type = ($form['format_type'] == '') ? EnumStatus::FIXED_LAYOUT : $form['format_type'];
                    if ($model->validate()) {                
                        $model->from = $form['from'];
                        $model->subject = $form['subject'];
                        $model->bcc = (isset($form['bcc'])) ? $form['bcc'] : '';
                        $model->html_head = $form['html_head'];
                        $model->html_body = $form['html_body'];
                        $model->bg_image_url = $form['bg_image_url'];
                        $model->update();
                        $this->dd(array(
                            'status'=>'success',
                            'json'=>'Record Updated'
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
     * Delete
     */
    public function actionDelete($id)
    {
        $model = EmailTemplate::model()->findByPk($id);
        if($model->delete()) {
            $this->dd(array(
                'status'=>'success',
                'json'=>'Record deleted'
            ));
        } else {
            $this->dd(array(
                'status'=>'error',
                'json'=>'Delete failed'
            ));
        }
    }

    /**
     * Preview
     */
    public function actionPreview($id=0)
    {
        $model = EmailTemplate::model()->find('id=:id AND account_id = :account_id', array(
            ':id'=>$id,
            ':account_id'=>Yii::app()->session['account_id']
        ));
        $this->renderPartial('preview', array('model'=>$model));
    }

    /**
     * Send test email
     */
    public function actionSendtest($id = null, $code = null, $rcpt = null)
    {
        if (isset($_POST['content'])) {
            try {

                $acct = AccountSetup::model()->find('id = :account_id', array(
                    ':account_id'=>Yii::app()->session['account_id']
                ));
                if ($acct != null) {
                    $emailrcpt = ($rcpt == null) ? $acct->email : $rcpt;
                    $info = array(
                        'sent_to'=> $emailrcpt,
                        'sent_name'=>'Test '. $emailrcpt,
                        'subject'=>EnumStatus::emailtemplates()[$code],
                        'bodyhtml'=>$_POST['content']
                    );

                    $template = EmailTemplate::model()->find('id = :id', array(
                        ':id'=>$id
                    ));
                    if ($template != null)
                    {
                        $from = ($template->from != '') ? $template->from : null;
                        $info = array(
                            'from' => $from,
                            'from_name' => $this->app(),
                            'sent_to'=> $emailrcpt,
                            'sent_name'=> $emailrcpt,
                            'subject'=> '[Send Test]'. EnumStatus::emailtemplates()[$code],
                            'bodyhtml'=>$_POST['content']
                        );
                    }

                    // Actual sending
                    $this->sendMail($info);
                    $this->dd(array(
                        'status'=>'success',
                        'json'=>'Email Sent'
                    ));
                }
            }
            catch(Exception $e) {
                $this->dd(array(
                    'status'=>'error',
                    'json'=>'Error Occured'
                ));
            }
        }
    }

}
