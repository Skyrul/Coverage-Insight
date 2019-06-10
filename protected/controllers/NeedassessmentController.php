<?php
class NeedassessmentController extends NAController
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
                    'step_instructions',
                    'step_customer1',
                    'step_customer2',
                    'step_dependents',
                    'step_policies_in_place',
                    'step_questions',
                    'step_top_concerns',
                    'step_life_changes',
                    'step_long_term_goals',
                    'step_appointment',
                    'thank_you'
                ),
                'roles' => array(
                    'admin',
                    'staff'
                )
            )
        );
    }

    protected function beforeAction($action)
    {
        // Check if that Question is enabled in Account Setup        
        $arr_page = array();

        array_push($arr_page, 'step_instructions');
        array_push($arr_page, 'step_customer1');
        array_push($arr_page, 'step_customer2');
        array_push($arr_page, 'step_dependents');

        foreach(InsuranceType::getAll() as $k=>$v):
            $id = $v['id'];
            $line_question = InsuranceType::getList($id);
            $ctr = AccountSetup::model()->find("id=:account_id AND is_" . $line_question['title'] . "_checked = 1", array(
                ':account_id' => Yii::app()->session['account_id']
            ));
            if ($ctr != null) {
                array_push($arr_page, 'step_policies_in_place?qid='. $id);
                array_push($arr_page, 'step_questions?qid='. $id);
            }
        endforeach;
        array_push($arr_page, 'step_top_concerns');
        array_push($arr_page, 'step_life_changes');
        array_push($arr_page, 'step_long_term_goals');
        array_push($arr_page, 'step_appointment');

        // Set progress bar
        Yii::app()->session['arr_pages'] = $arr_page;

        if (isset($_GET['qid'])) {
            $id = $_GET['qid'];
            $curpage = $this->action->id . '?qid=' . $id;
        } else {
            $curpage = $this->action->id;
        }
        
        // Skip button
        $position = 0;
        foreach($arr_page as $k=>$v) {
            // echo $v . "\n";
            if (strpos($v, $curpage) !== false) {
                $position = $k;
                break;
            }
        }
        $next_pos = $position + 1;
        Yii::app()->session['skip_url'] = '';
        if (isset($arr_page[$next_pos])) {
            Yii::app()->session['skip_url'] = $this->programURL() . '/' . $this->id . '/' . $arr_page[$next_pos];
        }

        // Current page index
        Yii::app()->session['page_index'] = $position;

        return parent::beforeAction($action);
    }

    /* Actions */
    public function actionStep_instructions()
    {
        if (! isset(Yii::app()->session['customer_id'])) {
            die('Invalid access');
        }
        
        $customer_id = Yii::app()->session['customer_id'];
        
        $criteria = new CDbCriteria();
        $criteria->condition = "account_id=:account_id AND id=:customer_id";
        $criteria->params = array(
            ':account_id' => Yii::app()->session['account_id'],
            ':customer_id' => $customer_id
        );
        $model = Customer::model()->find($criteria);
        $customer = Customer::model()->find($criteria);
        
        $this->render('step_instructions', array(
            'model' => $model,
            'customer' => $customer
        ));
    }

    public function actionStep_customer1()
    {
        if (isset(Yii::app()->session['customer_id'])) {
            $customer_id = Yii::app()->session['customer_id'];
        }
        if (isset($_GET['start'])) {
            if (! isset(Yii::app()->session['na_ok'])) {
                if (! isset($_GET['customer_id'])) {
                    die('Invalid access');
                } else {
                    $customer_id = $_GET['customer_id'];
                    Yii::app()->session['customer_id'] = $customer_id;
                }
            } else {
                $customer_id = Yii::app()->session['customer_id'];
            }
        }
        
        $criteria = new CDbCriteria();
        $criteria->condition = "account_id=:account_id AND id=:customer_id";
        $criteria->params = array(
            ':account_id' => Yii::app()->session['account_id'],
            ':customer_id' => $customer_id
        );
        $model = Customer::model()->find($criteria);
        $customer = Customer::model()->find($criteria);
        
        if (isset($_POST['Customer'])) {
            $model->attributes = $_POST['Customer'];
            if ($model->validate()) {
                $model->save();
                if (isset($_GET['direction'])) {
                    if ($_GET['direction'] == 'prev') {
                        if (! isset(Yii::app()->session['accessed_via_email'])) {
                            $this->redirect(array(
                                '/customer/listing'
                            ));
                        } else {
                            $this->redirect(array(
                                '/needassessment/step_instructions'
                            ));
                        }
                    } else if ($_GET['direction'] == 'next') {
                        $this->redirect(array(
                            '/needassessment/step_customer2'
                        ));
                    }
                }
            }
        }
        
        $this->render('step_customer1', array(
            'model' => $model,
            'customer' => $customer
        ));
    }

    public function actionStep_customer2()
    {
        if (! isset(Yii::app()->session['customer_id'])) {
            die('Invalid access');
        }
        
        $customer_id = Yii::app()->session['customer_id'];
        
        $criteria = new CDbCriteria();
        $criteria->condition = "account_id=:account_id AND id=:customer_id";
        $criteria->params = array(
            ':account_id' => Yii::app()->session['account_id'],
            ':customer_id' => $customer_id
        );
        $model = Customer::model()->find($criteria);
        $customer = Customer::model()->find($criteria);
        
        if (isset($_POST['Customer'])) {
            $model->attributes = $_POST['Customer'];
            if ($model->validate()) {
                $model->save();
                if (isset($_GET['direction'])) {
                    if ($_GET['direction'] == 'prev') {
                        $this->redirect(array(
                            '/needassessment/step_customer1?customer_id=' . $customer_id
                        ));
                    } else {
                        $this->redirect(array(
                            '/needassessment/step_dependents'
                        ));
                    }
                }
            }
        }
        
        $this->render('step_customer2', array(
            'model' => $model,
            'customer' => $customer
        ));
    }

    public function actionStep_dependents()
    {
        if (! isset(Yii::app()->session['customer_id'])) {
            die('Invalid access');
        }
        
        $customer_id = Yii::app()->session['customer_id'];
        
        $criteria = new CDbCriteria();
        $criteria->condition = "account_id=:account_id AND id=:customer_id";
        $criteria->params = array(
            ':account_id' => Yii::app()->session['account_id'],
            ':customer_id' => $customer_id
        );
        $customer = Customer::model()->find($criteria);
        
        // New Entry
        if (isset($_POST['DependentNew'])) {
            // $this->dd($_POST['DependentNew']);
            $newform = new Dependent();
            $newform->account_id = Yii::app()->session['account_id'];
            $newform->customer_id = $customer_id;
            $newform->dependent_name = $_POST['DependentNew']['dependent_name'];
            $newform->dependent_age = $_POST['DependentNew']['dependent_age'];
            if ($newform->save()) {
                Yii::app()->user->setFlash('success', 'Record saved');
            }
        }
        
        // Edit Entry
        if (isset($_POST['DependentEdit'])) {
            $criteria_edit = new CDbCriteria();
            $criteria_edit->condition = "account_id=:account_id AND customer_id=:customer_id AND id=:id";
            $criteria_edit->params = array(
                ':account_id' => Yii::app()->session['account_id'],
                ':customer_id' => $customer_id,
                ':id' => $_POST['DependentEdit']['id']
            );
            $edit = Dependent::model()->find($criteria_edit);
            if ($edit != null) {
                $edit->dependent_name = $_POST['DependentEdit']['dependent_name'];
                $edit->dependent_age = $_POST['DependentEdit']['dependent_age'];
                if ($edit->update()) {
                    Yii::app()->user->setFlash('success', 'Record updated');
                }
            }
        }
        
        if (isset($_GET['direction'])) {
            if ($_GET['direction'] == 'prev') {
                $this->redirect('step_customer2');
            } else if ($_GET['direction'] == 'next') {
                $arr_page = Yii::app()->session['arr_pages'];
                $x = $arr_page[Yii::app()->session['page_index'] + 1];
                $this->redirect($x);
            }
        }
        
        // Show all records related to Criteria
        $criteria_show = new CDbCriteria();
        $criteria_show->condition = "account_id=:account_id AND customer_id=:customer_id";
        $criteria_show->params = array(
            ':account_id' => Yii::app()->session['account_id'],
            ':customer_id' => $customer_id
        );
        $model = Dependent::model()->findAll($criteria_show);
        
        $this->render('step_dependents', array(
            'model' => $model,
            'customer' => $customer
        ));
    }

    public function actionStep_policies_in_place()
    {
        if (! isset(Yii::app()->session['customer_id'])) {
            die('Invalid access');
        }

        // Cycle logic - get starting point, if already set skipped
        if (isset($_GET['qid'])) {
            $id = $_GET['qid'];
        } else {
            die('Invalid steps');
        }
        $line_question = InsuranceType::getList($id);

        $customer_id = Yii::app()->session['customer_id'];
        
        // Delete record
        if (isset($_GET['action']) && isset($_GET['id'])) {
            if ($_GET['action'] == 'delete') {
                $rec = PoliciesInPlace::model()->findByPk($_GET['id']);
                if ($rec != null) {
                    $rec->delete();
                    Yii::app()->user->setFlash('success', 'Record deleted');
                }
            }
        }
        
        // Edit record
        if (isset($_POST['PolicyInplaceEdit'])) {
            foreach ($_POST['PolicyInplaceEdit'] as $nkey => $nval) {
                $rec = PoliciesInPlace::model()->findByPk($nval['id']);
                if ($rec != null) {
                    $rec->account_id = Yii::app()->session['account_id'];
                    $rec->customer_id = $customer_id;
                    $rec->assessment_guid = Yii::app()->session['assessment_guid'];
                    $rec->policy_parent_label = $nval['parent_label'];
                    $rec->policy_child_label = $nval['child_label'];
                    $rec->policy_child_selected = $nval['selected'];
                    $rec->insurance_company = $nval['insurance_company'];
                    $rec->save();
                    Yii::app()->user->setFlash('success', 'Record updated');
                }
            }
        }        
        
        // New record
        else if (isset($_POST['PolicyInplaceNew'])) {
            foreach ($_POST['PolicyInplaceNew'] as $nkey => $nval) {
                $rec = new PoliciesInPlace();
                $rec->account_id = Yii::app()->session['account_id'];
                $rec->customer_id = $customer_id;
                $rec->assessment_guid = Yii::app()->session['assessment_guid'];
                $rec->policy_parent_label = $nval['parent_label'];
                $rec->policy_child_label = $nval['child_label'];
                if ($nval['parent_label'] == 'Auto') {
                    $rec->policy_child_selected_year = $_POST['NewForm']['Add']['Year'];
                    $rec->policy_child_selected_make = $_POST['NewForm']['Add']['Make'];
                    $rec->policy_child_selected_model = $_POST['NewForm']['Add']['Model'];
                    $rec->insurance_company = $_POST['NewForm']['Add']['insurance_company'];
                } else {
                    $rec->policy_child_selected = $nval['selected'];
                    $rec->insurance_company = $nval['insurance_company'];
                }
                $rec->save();
            }
            Yii::app()->user->setFlash('success', 'Record saved');
        }

        // Submit Step navigation
        if (isset($_GET['direction'])) {
            $arr_page = Yii::app()->session['arr_pages'];
            $curpage = $this->action->id . '?qid=' . $id;
            $position = 0;
            foreach($arr_page as $k=>$v) {
                if ($v === $curpage) {
                    $position = $k;
                }
            }
            if ($position != 0) {
                if ($_GET['direction'] == 'prev') {
                    $prev_id = $position - 1;
                    $this->redirect($arr_page[$prev_id]);
                } else if ($_GET['direction'] == 'next') {
                    $next_id = $position + 1;
                    $this->redirect($arr_page[$next_id]);
                }
            }
        }
        
        // customer
        $criteria = new CDbCriteria();
        $criteria->condition = "account_id=:account_id AND id=:customer_id";
        $criteria->params = array(
            ':account_id' => Yii::app()->session['account_id'],
            ':customer_id' => $customer_id
        );
        $model = Customer::model()->find($criteria);
        $customer = Customer::model()->find($criteria);
        
        $this->render('step_policies_in_place', array(
            'model' => $model,
            'customer' => $customer,
            'line_question' => $line_question
        ));
    }

    public function actionStep_questions()
    {
        if (! isset(Yii::app()->session['customer_id'])) {
            die('Invalid access');
        }
        
        $customer_id = Yii::app()->session['customer_id'];

        // Cycle loop
        if (isset($_GET['qid'])) {
            $id = $_GET['qid'];
        } else {
            die('Invalid steps');
        }
        $line_question = InsuranceType::getList($id);
        

        // Saving
        if (isset($_POST['Question'])) {
            $cc = new CDbCriteria();
            $cc->condition = "account_id=:account_id AND customer_id=:customer_id AND policy_parent_label = :policy_parent_label";
            $cc->params = array(
                ':account_id' => Yii::app()->session['account_id'],
                ':customer_id' => $customer_id,
                ':policy_parent_label' => $line_question['title']
            );
            $rec = PolicyLineQuestion::model()->find($cc);
            if ($rec == null) {
                $rec = new PolicyLineQuestion();
            }
            $rec->customer_id = $customer_id;
            $rec->account_id = Yii::app()->session['account_id'];
            $rec->policy_parent_label = $line_question['title'];
            $rec->policy_child_label = $line_question['title'];
            $rec->policy_child_selected = $_POST['Question']['option'];
            $rec->save();
            Yii::app()->user->setFlash('success', 'Record saved');
        }
        
        // Submit Step navigation
        if (isset($_GET['direction'])) {
            $arr_page = Yii::app()->session['arr_pages'];
            $curpage = $this->action->id . '?qid=' . $id;
            $position = 0;
            foreach($arr_page as $k=>$v) {
                if ($v === $curpage) {
                    $position = $k;
                }
            }
            if ($position != 0) {
                if ($_GET['direction'] == 'prev') {
                    $prev_id = $position - 1;
                    $this->redirect($arr_page[$prev_id]);
                } else if ($_GET['direction'] == 'next') {
                    $next_id = $position + 1;
                    $this->redirect($arr_page[$next_id]);
                }
            }
        }
        
        $criteria = new CDbCriteria();
        $criteria->condition = "account_id=:account_id AND id=:customer_id";
        $criteria->params = array(
            ':account_id' => Yii::app()->session['account_id'],
            ':customer_id' => $customer_id
        );
        $model = Customer::model()->find($criteria);
        $customer = Customer::model()->find($criteria);
        
        $this->render('step_questions', array(
            'model' => $model,
            'customer' => $customer,
            'line_question' => $line_question
        ));
    }

    public function actionStep_top_concerns()
    {
        if (! isset(Yii::app()->session['customer_id'])) {
            die('Invalid access');
        }
        $customer_id = Yii::app()->session['customer_id'];
        
        if (isset($_POST['TopConcerns'])) {
            $cri = new CDbCriteria();
            $cri->condition = "account_id=:account_id AND customer_id=:customer_id";
            $cri->params = array(
                ':account_id' => Yii::app()->session['account_id'],
                ':customer_id' => $customer_id
            );
            TopConcerns::model()->deleteAll($cri);
            foreach ($_POST['TopConcerns']['option'] as $skey => $sval) {
                $rec = new TopConcerns();
                $rec->account_id = Yii::app()->session['account_id'];
                $rec->customer_id = Yii::app()->session['customer_id'];
                $rec->assessment_guid = Yii::app()->session['assessment_guid'];
                $rec->concern_question = $sval;
                $rec->concern_answer = $sval;
                $rec->save();
                Yii::app()->user->setFlash('success', 'Record saved');
            }
        }

        // Submit Step navigation
        if (isset($_GET['direction'])) {
            $arr_page = Yii::app()->session['arr_pages'];
            $curpage = $this->action->id;
            $position = 0;
            foreach($arr_page as $k=>$v) {
                if ($v === $curpage) {
                    $position = $k;
                }
            }
            if ($position != 0) {
                if ($_GET['direction'] == 'prev') {
                    $prev_id = $position - 1;
                    $this->redirect($arr_page[$prev_id]);
                } else if ($_GET['direction'] == 'next') {
                    $next_id = $position + 1;
                    $this->redirect($arr_page[$next_id]);
                }
            }
        }
        
        // filter
        $criteria = new CDbCriteria();
        
        // search customer
        $criteria->condition = "account_id=:account_id AND id=:customer_id";
        $criteria->params = array(
            ':account_id' => Yii::app()->session['account_id'],
            ':customer_id' => $customer_id
        );
        $customer = Customer::model()->find($criteria);
        $model = new Customer();
        
        $this->render('step_top_concerns', array(
            'customer' => $customer,
            'model' => $model
        ));
    }

    public function actionStep_life_changes()
    {
        if (! isset(Yii::app()->session['customer_id'])) {
            die('Invalid access');
        }
        $customer_id = Yii::app()->session['customer_id'];
        
        if (isset($_POST['LifeChanges'])) {
            $cri = new CDbCriteria();
            $cri->condition = "account_id=:account_id AND customer_id=:customer_id";
            $cri->params = array(
                ':account_id' => Yii::app()->session['account_id'],
                ':customer_id' => $customer_id
            );
            LifeChanges::model()->deleteAll($cri);
            foreach ($_POST['LifeChanges']['option'] as $skey => $sval) {
                $rec = new LifeChanges();
                $rec->account_id = Yii::app()->session['account_id'];
                $rec->customer_id = Yii::app()->session['customer_id'];
                $rec->assessment_guid = Yii::app()->session['assessment_guid'];
                $rec->life_question = $sval;
                $rec->life_answer = $sval;
                $rec->save();
                Yii::app()->user->setFlash('success', 'Record saved');
            }
        }
        
        if (isset($_GET['direction'])) {
            if ($_GET['direction'] == 'prev') {
                $this->redirect('step_top_concerns');
            } else {
                $this->redirect('step_long_term_goals');
            }
        }
        
        // filter
        $criteria = new CDbCriteria();
        
        // search customer
        $criteria->condition = "account_id=:account_id AND id=:customer_id";
        $criteria->params = array(
            ':account_id' => Yii::app()->session['account_id'],
            ':customer_id' => $customer_id
        );
        $customer = Customer::model()->find($criteria);
        $model = new Customer();
        
        $this->render('step_life_changes', array(
            'customer' => $customer,
            'model' => $model
        ));
    }

    public function actionStep_long_term_goals()
    {
        if (! isset(Yii::app()->session['customer_id'])) {
            die('Invalid access');
        }
        $customer_id = Yii::app()->session['customer_id'];
        
        if (isset($_POST['LongTermGoals'])) {
            $cri = new CDbCriteria();
            $cri->condition = "account_id=:account_id AND customer_id=:customer_id";
            $cri->params = array(
                ':account_id' => Yii::app()->session['account_id'],
                ':customer_id' => $customer_id
            );
            LongTermGoals::model()->deleteAll($cri);
            $rec = new LongTermGoals();
            $rec->account_id = Yii::app()->session['account_id'];
            $rec->customer_id = Yii::app()->session['customer_id'];
            $rec->assessment_guid = Yii::app()->session['assessment_guid'];
            $rec->first_goal = $_POST['LongTermGoals']['option'][1];
            $rec->second_goal = $_POST['LongTermGoals']['option'][2];
            $rec->save();
            Yii::app()->user->setFlash('success', 'Record saved');
        }
        
        if (isset($_GET['direction'])) {
            if ($_GET['direction'] == 'prev') {
                $this->redirect('step_life_changes');
            } else {
                $this->redirect('step_appointment');
            }
        }
        
        // filter
        $criteria = new CDbCriteria();
        
        // search customer
        $criteria->condition = "account_id=:account_id AND id=:customer_id";
        $criteria->params = array(
            ':account_id' => Yii::app()->session['account_id'],
            ':customer_id' => $customer_id
        );
        $customer = Customer::model()->find($criteria);
        $model = new Customer();
        
        $this->render('step_long_term_goals', array(
            'customer' => $customer,
            'model' => $model
        ));
    }

    public function actionStep_appointment()
    {
        if (! isset(Yii::app()->session['customer_id'])) {
            die('Invalid access');
        }
        $customer_id = Yii::app()->session['customer_id'];
        
        // filter
        $criteria = new CDbCriteria();
        
        // search customer
        $criteria->condition = "account_id=:account_id AND id=:customer_id";
        $criteria->params = array(
            ':account_id' => Yii::app()->session['account_id'],
            ':customer_id' => $customer_id
        );
        $customer = Customer::model()->find($criteria);
        
        // search existing Appointment
        $criteria->condition = "account_id=:account_id AND customer_id=:customer_id";
        $criteria->params = array(
            ':account_id' => Yii::app()->session['account_id'],
            ':customer_id' => $customer_id
        );
        $model = Appointment::model()->find($criteria);
        
        if (isset($_GET['direction'])) {
            if ($_GET['direction'] == 'prev') {
                $this->redirect('step_long_term_goals');
            } else if ($_GET['direction'] == 'next') {
                // deleting
                $criteria->condition = "account_id=:account_id AND customer_id=:customer_id";
                $criteria->params = array(
                    ':account_id' => Yii::app()->session['account_id'],
                    ':customer_id' => $customer_id
                );
                NeedsAssessment::model()->deleteAll($criteria);
                
                // saving
                $rec = new NeedsAssessment();
                $rec->account_id = Yii::app()->session['account_id'];
                $rec->customer_id = Yii::app()->session['customer_id'];
                $rec->assessment_guid = Yii::app()->session['assessment_guid'];
                $rec->assessment_submitted_to = $customer->primary_email;
                $rec->is_steps_completed = 1;
                $rec->save();
                
                unset(Yii::app()->session['accessed_via_email']);
                unset(Yii::app()->session['na_ok']);
                $this->redirect('thank_you');
            }
        }
        
        $this->render('step_appointment', array(
            'customer' => $customer,
            'model' => $model
        ));
    }

    public function actionThank_you()
    {
        if (! isset(Yii::app()->session['customer_id'])) {
            die('Invalid access');
        }
        $customer_id = Yii::app()->session['customer_id'];
        
        self::saveMetaKey();
        
        // filter
        $criteria = new CDbCriteria();
        
        // search customer
        $criteria->condition = "account_id=:account_id AND id=:customer_id";
        $criteria->params = array(
            ':account_id' => Yii::app()->session['account_id'],
            ':customer_id' => $customer_id
        );
        $customer = Customer::model()->find($criteria);
        
        $this->render('thank_you', array(
            'customer' => $customer
        ));
    }

    public function actionSave_exit()
    {
        if (! isset(Yii::app()->session['customer_id'])) {
            die('Invalid access');
        }
        $customer_id = Yii::app()->session['customer_id'];
        
        // filter
        $criteria = new CDbCriteria();
        
        // search customer
        $criteria->condition = "account_id=:account_id AND id=:customer_id";
        $criteria->params = array(
            ':account_id' => Yii::app()->session['account_id'],
            ':customer_id' => $customer_id
        );
        $customer = Customer::model()->find($criteria);
        unset(Yii::app()->session['accessed_via_email']);
        unset(Yii::app()->session['na_ok']);
        
        $this->render('save_exit', array(
            'customer' => $customer
        ));
    }

    /**
     * Delete dependent
     *
     * @return {none} Redirect user to same page
     */
    public function actionDependent_delete()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $model = Dependent::model()->findByPk($id);
            if ($model != null) {
                $model->delete();
                Yii::app()->user->setFlash('success', 'Record deleted');
                $this->redirect(Yii::app()->request->urlReferrer);
            }
        }
    }

    /*
     * Save NA Meta
     */
    public function saveMetaKey()
    {
        $criteria = new CDbCriteria();
        
        // Begin: Customer
        $criteria->condition = "account_id=:account_id AND id=:customer_id";
        $criteria->params = array(
            ':account_id' => Yii::app()->session['account_id'],
            ':customer_id' => Yii::app()->session['customer_id']
        );
        $action_key = 'NA:Customer';
        $records = Customer::model()->findAll($criteria);
        $this->saveActivity($action_key, CJSON::encode($records));
        // End: Customer
        
        $criteria->condition = "account_id=:account_id AND customer_id=:customer_id";
        $criteria->params = array(
            ':account_id' => Yii::app()->session['account_id'],
            ':customer_id' => Yii::app()->session['customer_id']
        );
        // Begin: Dependent
        $action_key = 'NA:Dependent';
        $records = Dependent::model()->findAll($criteria);
        $this->saveActivity($action_key, CJSON::encode($records));
        // End: Dependent
        
        // Begin: CurrentCoverage
        $action_key = 'NA:CurrentCoverage';
        $records = CurrentCoverage::model()->findAll($criteria);
        $this->saveActivity($action_key, CJSON::encode($records));
        // End: CurrentCoverage
        
        // Begin: Appointment
        $action_key = 'NA:Appointment';
        $records = Appointment::model()->findAll($criteria);
        $this->saveActivity($action_key, CJSON::encode($records));
        // End: Appointment
    }
}
