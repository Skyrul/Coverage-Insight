<?php
class PermissionController extends Controller 
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
     * Save Permission
     * */
    public function actionSave()
    {
        if(isset($_POST['Permission']))
        {
            $form = $_POST['Permission'];
            
            $model = ProgramPermission::model();
            
            $transaction = $model->dbConnection->beginTransaction();
            
            
            $sec_id = $form['security_group_id'];
            try {
                
                // delete old records for security_group_id
                $model->deleteAll('security_group_id = :sec_id AND account_id = :acct_id', array(
                    ':sec_id'=>$sec_id,
                    ':acct_id'=>Yii::app()->session['account_id'],
                ));
                
                
                // insert enable
                $program_codes = ProgramFeatures::model()->findAll();
                foreach($program_codes as $k=>$v){
                    $program_code = $v->program_code;
                    $insert = new ProgramPermission();
                    $insert->account_id = Yii::app()->session['account_id'];
                    $insert->security_group_id = $sec_id;
                    $insert->program_code = $program_code;
                    if (isset($form['enable'][$program_code])) {
                        $insert->enable = $form['enable'][$program_code];
                    } else {
                        $insert->enable = 'off';
                    }
                    if (isset($form['visible'][$program_code])) {
                        $insert->visible = $form['visible'][$program_code];
                    } else {
                        $insert->visible = 'off';
                    }
                    $insert->save();
                }
                
                $transaction->commit();
                
                $this->dd(array(
                    'status'=>'success',
                    'json'=>'Record saved'
                ));
            } 
            catch(Exception $e) {
                $transaction->rollback();
                $this->dd(array(
                    'status'=>'error',
                    'json'=>'Error saving your request',
                ));
            }
        }
    }

}
