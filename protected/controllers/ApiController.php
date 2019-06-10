<?php

class ApiController extends Controller
{

    public function filters()
    {
        return array(
            'accessControl' // perform access control for CRUD operations
        );
    }

    public function accessRules()
    {
        return array(
            array(
                'allow',
                'actions' => array(
                    'customer_save',
                    'customer_list',
                    'customer_search',
                    'actionitem_save',
                    'actionitem_delete',
                    'account_setup',
                    'dependent_delete',
                    'notes',
                    'notes_delete',
                    'reportdata_save',
                    'reportdata_call',
                    'policies_all',
                    'policy_order',
                    'currentcoverage_delete',
                    'currentcoverage_save',
                    'currentcoverage_update',
                    'cloudinary_usage',
                    'templatetags',
                ),
                'roles' => array(
                    'admin',
                    'staff'
                )
            ),
            array(
                'deny', // deny all users
                'users' => array(
                    '*'
                )
            )
        );
    }

    /* CUSTOMER */
    public function actionCustomer_save()
    {
        if (isset($_POST['Customer'])) {
            $model = new Customer();
            $model->attributes = $_POST['Customer'];
            if ($model->validate() && $model->save()) {
                // log action
                $this->logText("customer:". implode($_POST['Customer'], ",") . ", account:". Yii::app()->session['account_id'] .", action: save");
                
                $this->renderJSON(array(
                    'status' => 'success'
                ));
            } else {
                $this->renderJSON(array(
                    'status' => 'error',
                    'json' => $model->getErrors()
                ));
            }
        }
    }

    public function actionCustomer_list()
    {
        $criteria = new CDbCriteria();
        $criteria->condition = 'account_id=:account_id';
        $criteria->order = 'primary_firstname DESC';
        $criteria->params = array(
            ':account_id' => Yii::app()->session['account_id']
        );
        $records = Customer::model()->findAll($criteria);
        $this->renderJSON($records);
    }

    public function actionCustomer_search()
    {
        if (isset($_POST['id'])) {
            $criteria = new CDbCriteria();
            $criteria->condition = 'account_id=:account_id AND id=:customer_id';
            $criteria->params = array(
                ':account_id' => Yii::app()->session['account_id'],
                ':customer_id' => $_POST['id']
            );
            $records = Customer::model()->findAll($criteria);
            $this->renderJSON($records[0]);
        }
    }

    /* ACTION ITEM */
    public function actionActionitem_save()
    {
        // DEBUG
        // $this->renderJSON($_POST);
        if (isset($_POST['newitem'])) {
            $model = new ActionItem();
            $model->customer_id = $_POST['newitem']['customer_id'];
            $model->owner = $_POST['newitem']['owner'];
            $model->description = $_POST['newitem']['description'];
            if (isset($_POST['newitem']['is_opportunity'])) :
                $model->is_opportunity = (int) $_POST['newitem']['is_opportunity'];
            else :
                $model->is_opportunity = 0;
            endif;
            if (isset($_POST['newitem']['is_completed'])) :
                $model->is_completed = (int) $_POST['newitem']['is_completed'];
            else :
                $model->is_completed = 0;
            endif;
            $model->created_date = date('Y-m-d', strtotime($_POST['newitem']['created_date']));
            if ($_POST['newitem']['due_date'] != "") :
                $model->due_date = date('Y-m-d', strtotime($_POST['newitem']['due_date']));
			endif;
            
            $model->account_id = Yii::app()->session["account_id"];
            if ($model->validate() && $model->save()) {
                // log action
                $this->logText("items:". implode($_POST['newitem'], ",") . ", account:". Yii::app()->session['account_id'] .", action: save");
                
                $this->renderJSON(array(
                    'status' => 'success'
                ));
            } else {
                $this->renderJSON(array(
                    'status' => 'error',
                    'json' => $model->getErrors()
                ));
            }
        } else if (isset($_POST['ActionItem'])) {
            $model = ActionItem::model()->findByPk($_POST['ActionItem']['id']);
            if ($model != null) {
                $model->customer_id = $_POST['ActionItem']['customer_id'];
                $model->owner = $_POST['ActionItem']['owner'];
                $model->description = $_POST['ActionItem']['description'];
                if (isset($_POST['ActionItem']['is_opportunity'])) :
                    $model->is_opportunity = $_POST['ActionItem']['is_opportunity'];
                else :
                    $model->is_opportunity = 0;
                endif;
                if (isset($_POST['ActionItem']['is_completed'])) :
                    $model->is_completed = $_POST['ActionItem']['is_completed'];
                else :
                    $model->is_completed = 0;
                endif;
                $model->created_date = date('Y-m-d', strtotime($_POST['ActionItem']['created_date']));
                if ($_POST['ActionItem']['due_date'] != "") :
                    $model->due_date = date('Y-m-d', strtotime($_POST['ActionItem']['due_date']));
				endif;
                
                $model->account_id = Yii::app()->session["account_id"];
                if ($model->validate() && $model->update()) {
                    // log action
                    $this->logText("items:". implode($_POST['ActionItem'], ",") . ", account:". Yii::app()->session['account_id'] .", action: update");
                    
                    $this->renderJSON(array(
                        'status' => 'success'
                    ));
                } else {
                    $this->renderJSON(array(
                        'status' => 'error',
                        'json' => $model->getErrors()
                    ));
                }
            }
        }
    }

    public function actionActionitem_delete()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $model = ActionItem::model()->findByPk($id);
            if ($model != null) {
                $model->delete();
                
                // log action
                $this->logText("items:". implode($model->attributes, ",") . ", account:". Yii::app()->session['account_id'] .", action: delete");
                
                Yii::app()->user->setFlash('success', 'Record deleted');
                $this->redirect(array(
                    'account/action_item'
                ));
            }
        }
    }

    /* ACCOUNT SETUP */
    public function actionAccount_setup()
    {
        if (isset($_POST['ActionItem'])) {
            $model = new ActionItem();
            $model->attributes = $_POST['ActionItem'];
            if ($model->validate() && $model->save()) {
                // log action
                $this->logText("items:". implode($model->attributes, ",") . ", account:". Yii::app()->session['account_id'] .", action: save");
                
                $this->renderJSON(array(
                    'status' => 'success'
                ));
            } else {
                $this->renderJSON(array(
                    'status' => 'error',
                    'json' => $model->getErrors()
                ));
            }
        }
    }

    /* AGENT PREP & NA */
    public function actionDependent_delete()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $model = Dependent::model()->findByPk($id);
            if ($model != null) {
                $model->delete();
                
                // log action
                $this->logText("dependent:". $id . ", account:". Yii::app()->session['account_id'] .", action: delete");
                
                Yii::app()->user->setFlash('success', 'Record deleted');
                $this->redirect(Yii::app()->request->urlReferrer);
            }
        }
    }

    /* REPORTING */
    public function actionReportdata_save()
    {
        if (isset($_POST['DATA'])) {
            $report_name = $_POST['DATA']['report_name'];
            
            $criteria = new CDbCriteria();
            $criteria->condition = 'report_name=:report_name';
            $criteria->params = array(
                ':report_name' => $report_name
            );
            Reporting::model()->deleteAll($criteria);
            
            $model = new Reporting();
            $model->attributes = $_POST['DATA'];
            $model->save();
            
            $this->renderJSON(array(
                'status' => 'success',
                'json' => array(
                    'report_url' => '/reports/createpdf?report_name=' . $report_name
                )
            ));
        }
    }

    public function actionReportdata_call()
    {
        if (isset($_POST['report_name'])) {
            $report_name = $_POST['report_name'];
            
            $this->renderJSON(array(
                'status' => 'success',
                'json' => array(
                    'report_url' => '/reports/renderpdf?report_name=' . $report_name
                )
                // 'json'=> array('report_url'=>'/reports/createpdf_call?report_name='. $report_name)
            ));
        }
    }

    /* NOTES */
    public function actionNotes()
    {
        if (! isset($_POST['page_url'])) {
            Yii::app()->end();
        }
        $criteria = new CDbCriteria();
        $criteria->select = "msg_note, dom_element";
        $criteria->condition = "account_id = :account_id AND customer_id = :customer_id AND page_url = :page_url";
        $criteria->params = array(
            ':account_id' => Yii::app()->session['account_id'],
            ':customer_id' => Yii::app()->session['customer_id'],
            ':page_url' => $_POST['page_url']
        );
        $notes = Note::model()->findAll($criteria);
        if (! empty($notes)) {
            $this->renderJSON(array(
                'status' => 'success',
                'json' => $notes
            ));
        }
    }

    public function actionNotes_delete()
    {
        if (! isset($_POST['id'])) {
            Yii::app()->end();
        }
        $criteria = new CDbCriteria();
        $criteria->condition = "account_id = :account_id AND customer_id = :customer_id AND id = :id";
        $criteria->params = array(
            ':account_id' => Yii::app()->session['account_id'],
            ':customer_id' => Yii::app()->session['customer_id'],
            ':id' => $_POST['id']
        );
        $model = Note::model()->find($criteria);
        if (! empty($model)) {
            $model->delete();
            
            // log action
            $this->logText("notes:". implode($model->attributes, ",") . ", account:". Yii::app()->session['account_id'] .", action: delete");
            
            $this->renderJSON(array(
                'status' => 'success',
                'json' => 'Record deleted'
            ));
        }
    }

    /* Policies */
    public function actionPolicies_all()
    {
        $criteria_a2 = new CDbCriteria();
        $criteria_a2->condition = 'account_id=:account_id';
        $criteria_a2->params = array(
            ':account_id' => Yii::app()->session['account_id']
        );
        $criteria_a2->order = 'order_id ASC';
        $policies = AccountSetupPolicy::model()->findAll($criteria_a2);
        if (!empty($policies)) {
            $this->returnJSON($policies);
        }
    }

    public function actionPolicy_order($direction = null)
    {
        if ($direction == null && !isset($_POST['Account'])) { exit; }
        if ($direction == 'up') {
            $cr = new CDbCriteria();
            $curpos  = 0;
            $firstid = 0;
            $lastid  = 0;

            // Assign param
            $post = $_POST['Account'];

            // Get all db records filtered by parent label (example: AUTO)
            $cr->condition = 'account_id = :account_id AND policy_parent_label = :parent';
            $cr->params = array(
                ':account_id' => Yii::app()->session['account_id'],
                ':parent' => $post['type']
            );
            $cr->order = 'id ASC';
            $allrec = AccountSetupPolicy::model()->findAll($cr);
            if (!empty($allrec)) {
                // Get first order id
                $firstid = $allrec[0]['order_id'];

                // Get last order id
                foreach($allrec as $k=>$v) {
                    // Get current position of item on the db records
                    if ($post['id'] == $v->id) {
                        $curpos = $v->order_id;
                    }
                }    
            } // endforeach:
            
            echo 'Current Position: ' . $curpos . "\n";
            echo 'First Position: ' . $firstid . "\n";
            // echo 'Last Position: ' . $lastid . "\n";

        }
    }

    public function actionPolicy_order_April_06_2018()
    {
        $cr0 = new CDbCriteria();
        $cr1 = new CDbCriteria();
        $cr2 = new CDbCriteria();
        if (isset($_POST['Account'])) {
            $current_o = 0;
            $top_o = 0;
            $bottom_o = 0;
            $una_o = 0;
            $dulo_o = 0;
            
            $cr0->condition = 'account_id = :account_id AND policy_parent_label = :parent';
            $cr0->params = array(
                ':account_id' => Yii::app()->session['account_id'],
                ':parent' => $_POST['Account']['type']
            );
            $cr0->order = 'order_id ASC';
            $una = AccountSetupPolicy::model()->findAll($cr0);
            if (! empty($una)) {
                foreach ($una as $k => $v) {
                    $una_o = $v->order_id;
                    break;
                }
            }
            
            $cr1->condition = 'account_id = :account_id AND policy_parent_label = :parent AND id = :id';
            $cr1->params = array(
                ':account_id' => Yii::app()->session['account_id'],
                ':parent' => $_POST['Account']['type'],
                ':id' => $_POST['Account']['id']
            );
            $acct = AccountSetupPolicy::model()->find($cr1);
            if ($acct != null) {
                $current_o = $acct->order_id;
                $top_o = $acct->order_id - 1;
                $bottom_o = $acct->order_id + 1;
            }
            
            // Swap
            if ($_POST['Account']['direction'] == 'up') {
                $cr2->condition = 'account_id = :account_id AND order_id = :id';
                $cr2->params = array(
                    ':account_id' => Yii::app()->session['account_id'],
                    ':id' => $top_o
                );
                $acct2 = AccountSetupPolicy::model()->find($cr2);
                
                if ($una_o == $current_o) {
                    $this->dd(array(
                        'status' => 'error',
                        'json' => 'Cannot move up'
                    ));
                    exit();
                }
                
                if ($acct != null) {
                    $acct->order_id = $top_o;
                    $acct->save();
                }
                if ($acct2 != null) {
                    $acct2->order_id = $current_o;
                    $acct2->save();
                }
            } else if ($_POST['Account']['direction'] == 'down') {
                $cr2->condition = 'account_id = :account_id AND order_id = :id';
                $cr2->params = array(
                    ':account_id' => Yii::app()->session['account_id'],
                    ':id' => $bottom_o
                );
                $acct2 = AccountSetupPolicy::model()->find($cr2);
                
                if ($acct != null) {
                    $acct->order_id = $bottom_o;
                    $acct->save();
                }
                if ($acct2 != null) {
                    $acct2->order_id = $current_o;
                    $acct2->save();
                }
            }

            // log action
            $this->logText("action: policy ordering");
            
            // response
            $this->dd(array(
                'status' => 'success',
                'json' => 'Moved ' . $_POST['Account']['direction']
            ));
        }
    }

    public function actionGiftcards()
    {
        $model = GiftCards::model()->findAll('account_id = :account_id', array(
            ':account_id'=>Yii::app()->session['account_id']
        ));
        return $model;
    }

    public function actionTemplatetags($code='') 
    {
        echo EnumStatus::emailtemplatesparams($code);
    }

    public function actionCurrentcoverage_save()
    {
        if (isset($_POST['NewForm'])) {
            $data = $_POST['NewForm'];
            foreach ($data as $k => $v) {
                foreach ($v as $k1 => $v1) {
                    foreach ($v1 as $k2 => $v2) {
                        $key = $k2;
                        $value = $v2;
                        
                        // Saving
                        $model = new CurrentCoverage();
                        $model->customer_id = Yii::app()->session['customer_id'];
                        $model->policy_parent_code = $k;
                        $model->policy_child_label = $key;
                        $model->policy_child_selected = $value;
                        $model->account_id = Yii::app()->session['account_id'];
                        $model->save();
                    }
                }
            }
            
            // log action
            $this->logText("customer: ". Yii::app()->session['customer_id'] .", account:". Yii::app()->session['account_id'] .", action: save");
            
            $this->dd(array(
                'status' => 'success',
                'json' => 'Record saved'
            ));
        }
    }

    public function actionCurrentcoverage_update()
    {
        if (isset($_POST['EditForm'])) {
            $data = $_POST['EditForm'];
            foreach ($data as $k => $v) {
                foreach ($v as $k1 => $v1) {
                    foreach ($v1 as $k2 => $v2) {
                        $key = $k2;
                        $value = $v2;
                        
                        // Saving
                        $model = new CurrentCoverage();
                        $model->customer_id = Yii::app()->session['customer_id'];
                        $model->policy_parent_code = $k;
                        $model->policy_child_label = $key;
                        $model->policy_child_selected = $value;
                        $model->account_id = Yii::app()->session['account_id'];
                        $model->save();
                    }
                }
            }
            // log action
            $this->logText("customer: ". Yii::app()->session['customer_id'] .", account:". Yii::app()->session['account_id'] .", action: update");
            
            $this->dd(array(
                'status' => 'success',
                'json' => 'Record saved'
            ));
        }
    }

    public function actionCurrentcoverage_delete()
    {
        if (isset($_POST['data'])) {
            $data = explode(',', $_POST['data']);
            $cr = new CDbCriteria();
            foreach ($data as $v) {
                $cr->condition = "account_id = :account_id AND id = :id";
                $cr->params = array(
                    ':account_id' => Yii::app()->session['account_id'],
                    ':id' => $v
                );
                $rec = CurrentCoverage::model()->deleteAll($cr);
            }
            
            // log action
            $this->logText("account:". Yii::app()->session['account_id'] .", action: delete");           
            
            $this->dd(array(
                'status' => 'success',
                'json' => 'Record deleted!'
            ));
        }
    }
    
    public function actionCloudinary_usage()
    {
        $cl_cloud_name         = Yii::app()->params['cl_cloud_name'];
        $cl_api_key            = Yii::app()->params['cl_api_key_1'];
        $cl_api_secret         = Yii::app()->params['cl_api_secret_1'];
        $cl_endpoint           = "https://". $cl_api_key .":". $cl_api_secret ."@api.cloudinary.com/v1_1/". $cl_cloud_name . '/usage';
        $req = file_get_contents($cl_endpoint);
        $rp = $http_response_header;
        $this->dd(array(
            'status'=>'success',
            'json'=>$rp
        ));
    }
    
}
