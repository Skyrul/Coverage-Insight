<?php
class SecuritygroupController extends Controller 
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
                ),
                'roles' => array(EnumRoles::ADMINISTRATOR, EnumRoles::STAFF),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Save Security Group
     * */
    public function actionSave()
    {
        if(isset($_POST['SecurityGroup']))
        {
            $form = $_POST['SecurityGroup'];
            $model = new SecurityGroup;
            $model->attributes = $form;
            if ($model->validate()) {                
                $model->account_id = Yii::app()->session['account_id'];
                $model->group_name = $form['group_name'];
                $model->status = $form['status'];
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
     * Update Security Group
     * */
    public function actionUpdate()
    {
        if(isset($_POST['SecurityGroup']))
        {
            // Edit
            $form = $_POST['SecurityGroup'];
            if (isset($form['id'])) {
                $model = SecurityGroup::model()->findByPk($form['id']);
                if ($model != null)
                {
                    $model->group_name = $form['group_name'];
                    $model->status = $form['status'];
                    if ($model->save()) {
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
     * Delete Security Group
     */
    public function actionDelete($id)
    {
        $model = SecurityGroup::model()->findByPk($id);
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

}
