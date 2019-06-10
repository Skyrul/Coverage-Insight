<?php
class StaffController extends Controller 
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
                    'resend_verification',
                    'features_permission',
                ),
                'roles' => array(EnumRoles::ADMINISTRATOR, EnumRoles::STAFF),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Save Staff
     * */
    public function actionSave()
    {
        if(isset($_POST['Staff']))
        {
            $form = $_POST['Staff'];
            $model = new Staff;
            $model->attributes = $form;
            if ($model->validate()) {
                // Send email
                $this->sendMail(self::StaffRegistrationLink($model, array(
                    'logo'=>$this->applicationLogo(EnumLogo::CLIENT),
                    'url'=>$this->programURL(),
                )));
                
                $model->account_id = Yii::app()->session['account_id'];
                $model->roles = EnumRoles::STAFF;
                $model->status = EnumStatus::INACTIVE;
                $model->security_group_id = $form['security_group_id'];
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
     * Update Staff
     * */
    public function actionUpdate()
    {
        if(isset($_POST['Staff']))
        {
            // Edit
            $form = $_POST['Staff'];
            if (isset($form['id'])) {
                $model = Staff::model()->findByPk($form['id']);
                if ($model != null)
                {
                    $model->fullname = $form['fullname'];
                    $model->email = $form['email'];
                    $model->position = $form['position'];
                    $model->phone = $form['phone'];
                    $model->mobile = $form['mobile'];
                    $model->account_id = Yii::app()->session['account_id'];
                    $model->status = $form['status'];
                    $model->security_group_id = $form['security_group_id'];
                    if ($b = $model->update()) {
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
     * Delete Staff
     */
    public function actionDelete($id)
    {
        $model = Staff::model()->findByPk($id);
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
     * Resend Staff Registration Link/Verification
     * */
    public function actionResend_verification($id)
    {
        $criteria=new CDbCriteria;
        $criteria->condition="account_id=:account_id";
        $criteria->params=array(
            ':account_id'=>Yii::app()->session['account_id'],
        );
        $model = Staff::model()->findByPk($id);
        if($model!=null){

            $config = array(
                'logo'=>$this->applicationLogo(EnumLogo::CLIENT),
                'url'=>$this->programURL(),
            );

            $this->sendMail(self::StaffRegistrationLink($model, $config));
            
            $this->dd(array(
                'status'=>'success',
                'json'=>'Staff Registration Link Sent!'
            ));
        }
    }
    
    /**
     * This output staff permitted features
     * */
    public function actionFeatures_permission($js=null)
    {
        if ($js != null) {
            $this->renderPartial('features_permission');
        }
    }


    /*** Self Method ***/
    public function StaffRegistrationLink($model, $config)
    {
        // Send Staff Registration Email
        $sent_to = $model->email;
        $sent_name = $sent_to;

        $tmp = EmailTemplate::model()->find('account_id=:account_id AND code=:code', array(
            ':account_id'=>Yii::app()->session['account_id'],
            ':code'=>EnumStatus::EMAIL_SA,
        ));
        if ($tmp == null) {
            $subject = Yii::app()->name . ' - Customer Staff Registration';

            $reg_link = $config['url'] . '/site/staff_verification?email=' . $sent_to;

            $html ='<img src="'. $config['logo'] .'"><br>';
            $html.='Link for your account on '. Yii::app()->name . '<br>';
            $html.='Email Address:&nbsp;'. $sent_to . '<br><br>';
            $html.='<a href="'. $reg_link . '">Click Here to create your account</a><br>';
            $html.='<br><br>';
            $html.='<span>Copyright '.date('Y').' '. Yii::app()->name.' | EngageX</span>';
        } else {
            $subject = $tmp->subject;

            $reg_link = $config['url'] . '/site/staff_verification?email=' . $sent_to;

            $bg_image_url = ($tmp->bg_image_url != '') ? $tmp->bg_image_url : '';
            $cwidth = '';
            if ($tmp->format_type == EnumStatus::FLUID_LAYOUT) {
                $cwidth = 'width: 100%;';
            }
            $bg_style = 'background: url('. $bg_image_url .');';
            
            $html  = '<table background="'. $bg_image_url .'" style="'. $bg_style . $cwidth .' height: 700px;">';
            $html .= '<tr valign="top" style="height: 0px; line-height: 20px;">';
            $html .= '<td style="padding: 20px;">';
            $html .= $tmp->html_head . "\n" . $tmp->html_body;
            $html .= '</td>';
            $html .= '</tr>';
            $html .= '</table>';
            $html = $this->standardSmartTagsReplace($html);
            $html = str_replace('[registration_link]', $reg_link, $html);
        }


        return array(
            'sent_to'=> $sent_to,
            'sent_name'=> $sent_name,
            'subject'=> $subject,
            'bodyhtml'=> $html,
        );
    }

}
