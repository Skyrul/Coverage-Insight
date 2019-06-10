<?php

class CirController extends Controller
{

    public function filters()
    {
        return array(
            'accessControl'
        );
    }

    public function accessRules()
    {
        return array(
            array(
                'allow',
                'actions' => array(
                    'step_customer1',
                    'step_customer2',
                    'step_dependents',
                    'step_educations',
                    'step_current_coverages',
                    'step_concerns_questions',
                    'step_long_term_goals',
                    'step_referrals',
                    'step_action_items',
                    'step_send_print_email',
                    'step_review_complete',
                    'dependent_delete',
                    'save_education_resource'
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

    protected function beforeAction($action)
    {
        // Check if that Question is enabled in Account Setup        
        $arr_page = array();

        array_push($arr_page, 'step_customer1');
        array_push($arr_page, 'step_customer2');
        array_push($arr_page, 'step_dependents');
        foreach(InsuranceType::getAll() as $k=>$v):
            $id = $v['id'];
            $line_insurance = InsuranceType::getList($id);
            $ctr = AccountSetup::model()->find("id=:account_id AND is_" . $line_insurance['title'] . "_checked = 1", array(
                ':account_id' => Yii::app()->session['account_id']
            ));
            if ($ctr != null) {
                array_push($arr_page, 'step_educations?qid='. $id);
                array_push($arr_page, 'step_current_coverages?qid='. $id);
                array_push($arr_page, 'step_concerns_questions?qid='. $id);
            }
        endforeach;
        array_push($arr_page, 'step_long_term_goals');
        array_push($arr_page, 'step_referrals');
        array_push($arr_page, 'step_action_items');
        array_push($arr_page, 'step_send_print_email');

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
                        $this->redirect(array(
                            '/customer/listing'
                        ));
                    } else if ($_GET['direction'] == 'next') {
                        $this->redirect(array(
                            '/cir/step_customer2'
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
        $customer_id = Yii::app()->session['customer_id'];
        
        $criteria = new CDbCriteria();
        $criteria->condition = "account_id=:account_id AND id=:customer_id";
        $criteria->params = array(
            ':account_id' => Yii::app()->session['account_id'],
            ':customer_id' => $customer_id
        );
        $model = Customer::model()->find($criteria);
        $customer = Customer::model()->find($criteria);
        
        // $this->dd($model);
        if (isset($_POST['Customer'])) {
            $model->attributes = $_POST['Customer'];
            if ($model->validate()) {
                $model->save();
                if (isset($_GET['direction'])) {
                    if ($_GET['direction'] == 'prev') {
                        $this->redirect(array(
                            '/cir/step_customer1?customer_id=' . $customer_id
                        ));
                    } else {
                        $this->redirect(array(
                            '/cir/step_dependents'
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
            // $this->dd($_POST['DependentEdit']);
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

    /**
     * Educations
     */
    public function actionStep_educations()
    {
        if (! isset(Yii::app()->session['customer_id'])) {
            die('Invalid access');
        }
        
        $customer_id = Yii::app()->session['customer_id'];
        
        // Cycle logic - get starting point, if already set skipped
        if (isset($_GET['qid'])) {
            $id = $_GET['qid'];
        } else {
            die('Invalid steps');
        }
        
        $line_insurance = InsuranceType::getList($id);
        
        if (isset($_POST['Education'])) {
            // $this->dd($_POST['Education']);
            $cc = new CDbCriteria();
            $cc->condition = "account_id=:account_id AND customer_id=:customer_id AND policy_parent_label = :policy_parent_label";
            $cc->params = array(
                ':account_id' => Yii::app()->session['account_id'],
                ':customer_id' => Yii::app()->session['customer_id'],
                ':policy_parent_label' => $line_insurance['title']
            );
            Education::model()->deleteAll($cc);
            
            foreach ($_POST['Education']['Option']['policy_child_label'] as $sk => $sv) {
                $rec = new Education();
                $rec->customer_id = $customer_id;
                $rec->account_id = Yii::app()->session['account_id'];
                $rec->policy_parent_label = $line_insurance['title'];
                $rec->policy_child_label = $sv;
                $rec->policy_child_selected = $sv;
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
        
        $criteria = new CDbCriteria();
        $criteria->condition = "account_id=:account_id AND id=:customer_id";
        $criteria->params = array(
            ':account_id' => Yii::app()->session['account_id'],
            ':customer_id' => $customer_id
        );
        $model = Customer::model()->find($criteria);
        $customer = Customer::model()->find($criteria);
        
        $this->render('step_educations', array(
            'model' => $model,
            'customer' => $customer,
            'line_insurance' => $line_insurance
        ));
    }

    /**
     * Current Coverages
     */
    public function actionStep_current_coverages()
    {
        if (! isset(Yii::app()->session['customer_id'])) {
            die('Invalid access');
        }
        
        $customer_id = Yii::app()->session['customer_id'];
        // Cycle logic - get starting point, if already set skipped
        if (isset($_GET['qid'])) {
            $id = $_GET['qid'];
        } else {
            die('Invalid steps');
        }
        
        $line_insurance = InsuranceType::getList($id);

        if (isset($_GET['direction'])) {
            // Save Record even Prev or Next
            $credit = new CDbCriteria();
            if (isset($_POST['CurrentCoverage']['policy_child_label'])) {
                foreach ($_POST['CurrentCoverage']['policy_child_label'] as $k => $v) {
                    $policy_parent_label = $k;
                    foreach ($v as $k1 => $v1) {
                        $credit->condition = 'account_id = :account_id ' . 'AND customer_id = :customer_id ' . 'AND policy_parent_code = :policy_parent_label ' . 'AND policy_child_label = :policy_child_label';
                        
                        $credit->params = array(
                            ':account_id' => Yii::app()->session['account_id'],
                            ':customer_id' => Yii::app()->session['customer_id'],
                            ':policy_parent_label' => $policy_parent_label,
                            ':policy_child_label' => $k1
                        );
                        $edit = CurrentCoverage::model()->find($credit);
                        if ($edit != null) {
                            $edit->cir_answer = $v1;
                            $edit->save();
                        }
                    }
                }
            }
            
            if (isset($_POST['NA'])) {
                // Line Question
                foreach ($_POST['NA']['LineQuestion'] as $k1 => $v1) {
                    $credit->condition = 'account_id = :account_id ' . 'AND customer_id = :customer_id ' . 'AND policy_parent_label = :policy_parent_label ';
                    $credit->params = array(
                        ':account_id' => Yii::app()->session['account_id'],
                        ':customer_id' => Yii::app()->session['customer_id'],
                        ':policy_parent_label' => $k1
                    );
                    PolicyLineQuestion::model()->updateAll(array(
                        'cir_answer' => $v1
                    ), $credit);
                }
                
                // LifeChanges
                $v2 = $_POST['NA']['LifeChanges'];
                $credit->condition = 'account_id = :account_id ' . 'AND customer_id = :customer_id ';
                $credit->params = array(
                    ':account_id' => Yii::app()->session['account_id'],
                    ':customer_id' => Yii::app()->session['customer_id']
                );
                LifeChanges::model()->updateAll(array(
                    'cir_answer' => $v2
                ), $credit);
                
                // TopConcerns
                $v3 = $_POST['NA']['TopConcerns'];
                $credit->condition = 'account_id = :account_id ' . 'AND customer_id = :customer_id ';
                $credit->params = array(
                    ':account_id' => Yii::app()->session['account_id'],
                    ':customer_id' => Yii::app()->session['customer_id']
                );
                TopConcerns::model()->updateAll(array(
                    'cir_answer' => $v3
                ), $credit);
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
        
        $this->render('step_current_coverages', array(
            'model' => $model,
            'customer' => $customer,
            'line_insurance' => $line_insurance,
        ));
    }

    /**
     * Concerns and Questions
     */
    public function actionStep_concerns_questions()
    {
        $credit = new CDbCriteria();
        
        if (! isset(Yii::app()->session['customer_id'])) {
            die('Invalid access');
        }
        
        $customer_id = Yii::app()->session['customer_id'];
        // Cycle logic - get starting point, if already set skipped
        if (isset($_GET['qid'])) {
            $id = $_GET['qid'];
        } else {
            die('Invalid steps');
        }
        
        $line_insurance = InsuranceType::getList($id);

        // Top Concerns
        if (isset($_POST['TopConcern'])) {
            // TopConcern
            foreach ($_POST['TopConcern']['Option']['cir_answer'] as $k1 => $v1) {
                $credit->condition = 'account_id = :account_id ' . 'AND customer_id = :customer_id ' . 'AND id = :id';
                $credit->params = array(
                    ':account_id' => Yii::app()->session['account_id'],
                    ':customer_id' => Yii::app()->session['customer_id'],
                    ':id' => $k1
                );
                TopConcerns::model()->updateAll(array(
                    'cir_answer' => $v1
                ), $credit);
            }
        }
        
        // Goals Concerns
        if (isset($_POST['GoalConcern'])) {
            // TopConcern
            foreach ($_POST['GoalConcern']['Option']['cir_answer'] as $k1 => $v1) {
                $credit->condition = 'account_id = :account_id ' . 'AND customer_id = :customer_id ' . 'AND id = :id';
                $credit->params = array(
                    ':account_id' => Yii::app()->session['account_id'],
                    ':customer_id' => Yii::app()->session['customer_id'],
                    ':id' => $k1
                );
                GoalsConcern::model()->updateAll(array(
                    'cir_answer' => $v1
                ), $credit);
            }
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
        
        $this->render('step_concerns_questions', array(
            'model' => $model,
            'customer' => $customer,
            'line_insurance' => $line_insurance
        ));
    }

    /**
     * Long term goals
     */
    public function actionStep_long_term_goals()
    {
        if (! isset(Yii::app()->session['customer_id'])) {
            die('Invalid access');
        }
        
        $customer_id = Yii::app()->session['customer_id'];

        // customer
        $criteria = new CDbCriteria();
        $criteria->condition = "account_id=:account_id AND id=:customer_id";
        $criteria->params = array(
            ':account_id' => Yii::app()->session['account_id'],
            ':customer_id' => $customer_id
        );
        $model = Customer::model()->find($criteria);
        $customer = Customer::model()->find($criteria);

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
        
        
        $this->render('step_long_term_goals', array(
            'model' => $model,
            'customer' => $customer
        ));
    }

    /**
     * Referrals
     */
    public function actionStep_referrals()
    {
        if (isset($_GET['customer_id'])) {
            $customer_id = $_GET['customer_id'];
        }
        
        if (isset(Yii::app()->session['customer_id'])) {
            $customer_id = Yii::app()->session['customer_id'];
        }
        // customer id
        Yii::app()->session['customer_id']=$customer_id;
        
        $criteria = new CDbCriteria();
        $criteria->condition = "account_id=:account_id AND id=:customer_id";
        $criteria->params = array(
            ':account_id' => Yii::app()->session['account_id'],
            ':customer_id' => Yii::app()->session['customer_id']
        );
        $model = Customer::model()->find($criteria);
        $customer = Customer::model()->find($criteria);
        
        // Add
        if (isset($_POST['ReferralNew'])) {
            $referral = new Referral();
            $referral->attributes = $_POST['ReferralNew'];
            $referral->account_id = Yii::app()->session['account_id'];
            $referral->customer_id = Yii::app()->session['customer_id'];
            if ($referral->validate()) {
                $referral->save();
                Yii::app()->user->setFlash('success', 'Record saved');
                $this->redirect(Yii::app()->request->urlReferrer);
            } else {
                Yii::app()->user->setFlash('form_error', CJSON::encode($referral->getErrors()));
            }
        }
        
        // // Edit
        // if (isset($_POST['ReferralEdit'])) {
            
        //     $frm = $_POST['ReferralEdit'];
        //     $criteria->condition = "account_id=:account_id AND customer_id=:customer_id AND id = :id";
        //     $criteria->params = array(
        //         ':account_id' => Yii::app()->session['account_id'],
        //         ':customer_id' => Yii::app()->session['customer_id'],
        //         ':id' => $frm['id']
        //     );
        //     $referral = Referral::model()->find($criteria);
        //     if ($referral != null) {
        //         $referral->attributes = $frm;
        //         if ($referral->validate()) {
        //             $referral->save();
        //             Yii::app()->user->setFlash('success', 'Record saved');
        //         } else {
        //             Yii::app()->user->setFlash('form_error', CJSON::encode($referral->getErrors()));
        //         }
        //     }
        // }
        
        // Delete
        if (isset($_GET['action'])) {
            if ($_GET['action'] == 'delete') {
                $criteria->condition = "account_id=:account_id AND id = :id";
                $criteria->params = array(
                    ':account_id' => Yii::app()->session['account_id'],
                    ':id' => $_GET['id']
                );
                Referral::model()->deleteAll($criteria);
                Yii::app()->user->setFlash('success', 'Record deleted');
                $this->redirect($this->programURL() . '/' . $this->id . '/' . $this->action->id);
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
        
        $this->render('step_referrals', array(
            'model' => $model,
            'customer' => $customer
        ));
    }

    /**
     * Action Items
     */
    public function actionStep_action_items()
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
        
        $this->render('step_action_items', array(
            'model' => $model,
            'customer' => $customer
        ));
    }

    /**
     * Send or Print Customer Review
     */
    public function actionStep_send_print_email()
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
        
        // Post Action
        if (isset($_POST['Customer'])) {
            $frm = $_POST['Customer'];
            $primary = $customer->primary_email;
            $secondary = $customer->secondary_email;
            
            if (isset($_GET['action'])) {
                $action = $_GET['action'];
                $pdf_document = $this->normalize_path($_SERVER['DOCUMENT_ROOT'] . '/pdf/cir_' . $customer_id . '.pdf');
                if (! file_exists($pdf_document)) {
                    $url = '/reports/renderpdf/report_name/cir/report_type/basic/customer_id/' . $customer_id;
                    Yii::app()->runController(Yii::app()->createURL($url));
                    sleep(1);
                }
                if ($action == 'send') :
                    $cir_sent = false;
                    $submitted_to = '';

                    $code = 'CIR';
                    $model = EmailTemplate::model()->find('account_id=:account_id AND code=:code', array(
                        ':account_id'=> Yii::app()->session['account_id'],
                        ':code'=>$code,
                    ));
                    if ($model == null) {
                        $maincontent_resource = '<h2>Thank you for taking our Insurance Review!</h2>The summary of our review are generated and attached on this Email. <br><br>';
                        $maincontent_resource .= self::clientResources();
                        $subject = Yii::app()->name . ' - Customer Insurance Review';
                    } else {
                        $combined = $model->html_head . "\n" . $model->html_body;
                        // Standard tags
                        $maincontent_resource = $this->standardSmartTagsReplace($combined);
                        // Custom tags
                        $maincontent_resource = str_replace('[resources]', self::clientResources(), $maincontent_resource);
                        $subject = $model->subject;
                    }
                    
                    if (isset($frm['Primary'])) {
                        $sent = $this->sendMail(array(
                            'sent_to' => $primary,
                            'sent_name' => 'Primary Customer',
                            'subject' => $subject,
                            'bodyhtml' => $maincontent_resource,
                            'attachment' => $pdf_document
                        ));
                        $cir_sent = $sent;
                        $submitted_to .= $primary;
                    }
                    if (isset($frm['Secondary'])) {
                        $sent = $this->sendMail(array(
                            'sent_to' => $secondary,
                            'sent_name' => 'Secondary Customer',
                            'subject' => $subject,
                            'bodyhtml' => $maincontent_resource,
                            'attachment' => $pdf_document
                        ));
                        $cir_sent = $sent;
                        $submitted_to .= ';' . $secondary;
                    }
                    Yii::app()->session['submitted_to'] = $submitted_to;
                    
                    if ($cir_sent) {
                        self::saveMetaKey();
                        Yii::app()->user->setFlash('success', 'Customer Insurance Review Sent');
                    } else {
                        Yii::app()->user->setFlash('error', 'Email not sent');
                    }
                       
                    endif;
                
            }
        }
        
        if (isset($_GET['direction'])) {
            if ($_GET['direction'] == 'prev') {
                $this->redirect('step_action_items');
            } else if ($_GET['direction'] == 'next') {
                self::saveMetaKey();
                $this->redirect('step_review_complete');
            }
        }
        
        $this->render('step_send_print_email', array(
            'model' => $model,
            'customer' => $customer
        ));
    }

    /**
     * Review to Complete
     */
    public function actionStep_review_complete()
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
        
        if (isset($_GET['direction'])) {
            if ($_GET['direction'] == 'prev') {
                $this->redirect('step_send_print_email');
            } else if ($_GET['direction'] == 'next') {
                $this->redirect('/account/action_item?cmd=OPEN_ACTION_ITEM_BY&customer_id=' . $customer_id);
            }
        }
        
        $this->render('step_review_complete', array(
            'model' => $model,
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
    
    /**
     * Save education resource
     * */
    public function actionSave_education_resource($insurance_type = 'none')
    {
        if(isset($_POST['resource'])) {
            // $this->dd($_POST['resource']);
            $data = $_POST['resource'];
            
            // Delete past selections
            $cr = new CDbCriteria();
            $cr->condition = 'account_id = :account_id AND customer_id = :customer_id AND insurance_type = :insurance_type';
            $cr->params = array(
                ':account_id'=>Yii::app()->session['account_id'],
                ':customer_id'=>Yii::app()->session['customer_id'],
                ':insurance_type'=>$data['insurance_type'],
            );
            EducationResource::model()->deleteAll($cr);
            
            // Save selections
            foreach($data['public_id'] as $v){
                $model = new EducationResource();
                $model->account_id = Yii::app()->session['account_id'];
                $model->customer_id = Yii::app()->session['customer_id'];
                $model->insurance_type = $data['insurance_type'];
                $model->json = $v;
                $model->save();
            }
            
            $this->dd(array(
                'status'=>'success',
                'json'=>'Record Saved',
            ));
        }
    }

    public function clientResources()
    {
        // Assigned Resource Files
        $client_resources = ClientResources::model()->findAll('account_id = :account_id', array(
            ':account_id'=> Yii::app()->session['account_id']
        ));
        $maincontent_resource = '';
        if(!empty($client_resources)):
            $maincontent_resource .= '<h4 style="border-bottom:1px dotted black;">(Click to view attached resources)</h4>';
            foreach($client_resources as $k=>$v):
                $json = json_decode($v->json);
                $public_id = explode('/', $json->public_id);
                
                $cc = EducationResource::model()->find('account_id = :account_id AND customer_id = :customer_id AND json = :public_id', array(
                    ':account_id'=>Yii::app()->session['account_id'],
                    ':customer_id'=>Yii::app()->session['customer_id'],
                    ':public_id'=>$public_id[1]
                ));
                if ($cc != null) {
                    $custom_label = '';
                    if ($v->custom_label == '0' || $v->custom_label == '') {
                        $custom_label = $public_id[1];
                    } else {
                        $custom_label = $v->custom_label;
                    }
                    $maincontent_resource .= '<span>';
                    $maincontent_resource .= '<h4>';
                    $maincontent_resource .= ''. $custom_label .'&nbsp;&nbsp;';
                    $maincontent_resource .= '</h4>';
                    $maincontent_resource .= 'View Resource <a href="'. $json->secure_url .'" target="_blank">Here:<br>';
                    if ($this->endsWith($json->secure_url, '.pdf')) {
                        $maincontent_resource .= '<img src="http://iconbug.com/data/5b/507/52ff0e80b07d28b590bbc4b30befde52.png" style="width: 34px;">';
                    }
                    else if ($this->endsWith($json->secure_url, '.jpg')) {
                        $maincontent_resource .= '<img src="http://downloadicons.net/sites/default/files/gif-file-icon-1727.png" style="width: 34px;">';
                    }
                    else if ($this->endsWith($json->secure_url, '.gif')) {
                        $maincontent_resource .= '<img src="http://downloadicons.net/sites/default/files/gif-file-icon-1727.png" style="width: 34px;">';
                    }
                    else if ($this->endsWith($json->secure_url, '.png')) {
                        $maincontent_resource .= '<img src="http://downloadicons.net/sites/default/files/gif-file-icon-1727.png" style="width: 34px;">';
                    }
                    else {
                        $maincontent_resource .= '<img src="https://image.freepik.com/free-icon/raw-file-format-symbol_318-45283.jpg" style="width: 34px;">';
                    }
                    $maincontent_resource .= '</a>';
                    $maincontent_resource .= '</span><br>';
                }
            endforeach;
            $maincontent_resource .= '<br>';
        endif;
        return $maincontent_resource;
    }

    /**
     * Save CIR Meta
     */
    public function saveMetaKey()
    {
        $criteria = new CDbCriteria();
        
        // Begin: CIReview
        $criteria->condition = "account_id=:account_id AND customer_id=:customer_id";
        $criteria->params = array(
            ':account_id' => Yii::app()->session['account_id'],
            ':customer_id' => Yii::app()->session['customer_id']
        );
        $record = CIReview::model()->find($criteria);
        if ($record == null) {
            $record = new CIReview();
            $record->assessment_guid = Yii::app()->session['assessment_guid'];
            $record->account_id = Yii::app()->session['account_id'];
            $record->customer_id = Yii::app()->session['customer_id'];
            $record->ci_review_submitted_to = Yii::app()->session['submitted_to'];
            $record->is_completed = 1;
            $current_date = new CDbExpression('NOW()');
            $record->ci_review_date = $current_date;
            $record->ci_review_guid = md5($current_date);
            $record->save();
        }
        // End: CIReview
    }
}