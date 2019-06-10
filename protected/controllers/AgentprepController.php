<?php

class AgentprepController extends Controller
{
	public function filters()
	{
	    return array(
	        'accessControl', // perform access control for CRUD operations
	    );
	}

	public function accessRules()
	{
	    return array(
	        array('allow',
	            'actions'=>array(
	            	'step_customer1',
	            	'step_customer2',
                    'step_dependents',
                    'step_current_coverages',
                    'step_appointment',
                    'step_send_na',
	            ),
	            'roles'=>array('admin', 'staff'),
	        ),
	        array('deny',  // deny all users
	            'users'=>array('*'),
	        ),
	    );
	}

	/* Override */
	public $menu_collapsed = 'goto-sub-collapse';
	
	/* Actions */
	public function actionStep_customer1()
	{
                if (isset(Yii::app()->session['customer_id'])) {
                    $customer_id = Yii::app()->session['customer_id'];
                }
                if (isset($_GET['start'])) {
                    if (!isset($_GET['customer_id'])) {
                            die('Invalid access');
                    }
                    $customer_id = $_GET['customer_id'];
                }
                
                // customer id
		Yii::app()->session['customer_id']=$customer_id;

		$criteria = new CDbCriteria;
		$criteria->condition = "account_id=:account_id AND id=:customer_id";
		$criteria->params=array(
			':account_id'=>Yii::app()->session['account_id'],
			':customer_id'=>$customer_id,
		);
		$model = Customer::model()->find($criteria);
		$customer = Customer::model()->find($criteria);

		if(isset($_POST['Customer'])) {
                    $model->attributes=$_POST['Customer'];
                    if ($model->validate()) {
                            $model->save();
                            $this->redirect(array('/agentprep/step_customer2'));
                    }
		}

		$this->render('step_customer1', array('model'=>$model, 'customer'=> $customer));
	}

	public function actionStep_customer2()
	{
		if (!isset(Yii::app()->session['customer_id'])) {
			die('Invalid access');
		}

		$customer_id = Yii::app()->session['customer_id'];

		$criteria = new CDbCriteria;
		$criteria->condition = "account_id=:account_id AND id=:customer_id";
		$criteria->params=array(
			':account_id'=>Yii::app()->session['account_id'],
			':customer_id'=>$customer_id,
		);
		$model = Customer::model()->find($criteria);
		$customer = Customer::model()->find($criteria);

		if(isset($_POST['Customer'])) {
                    $model->attributes=$_POST['Customer'];
                    if ($model->validate()) {
                        $model->save();
                        if(isset($_GET['direction'])) {
                            if ($_GET['direction'] == 'previous') {
                                $this->redirect(array('/agentprep/step_customer1?customer_id='. $customer_id));
                            } else {
                                $this->redirect(array('/agentprep/step_dependents'));
                            }
                        }
                    }
		}

		$this->render('step_customer2', array('model'=>$model, 'customer'=>$customer));
	}

	public function actionStep_dependents()
	{
		if (!isset(Yii::app()->session['customer_id'])) {
			die('Invalid access');
		}

		$customer_id = Yii::app()->session['customer_id'];

		$criteria = new CDbCriteria;
		$criteria->condition = "account_id=:account_id AND id=:customer_id";
		$criteria->params=array(
			':account_id'=>Yii::app()->session['account_id'],
			':customer_id'=>$customer_id,
		);
		$customer = Customer::model()->find($criteria);

		// New Entry
		if (isset($_POST['DependentNew'])) {
			//$this->dd($_POST['DependentNew']);
			$newform = new Dependent;
			$newform->account_id=Yii::app()->session['account_id'];
			$newform->customer_id=$customer_id;
			$newform->dependent_name=$_POST['DependentNew']['dependent_name'];
			$newform->dependent_age=$_POST['DependentNew']['dependent_age'];
			if($newform->save()) {
                            //Yii::app()->user->setFlash('success', 'Record saved');
                            $this->dd(array(
                                'status'=>'success',
                                'json'=>'New record saved'
                            ));
			}
		}

		// Edit Entry
		if (isset($_POST['DependentEdit'])) {
			//$this->dd($_POST['DependentEdit']);
			$criteria_edit = new CDbCriteria;
			$criteria_edit->condition = "account_id=:account_id AND customer_id=:customer_id AND id=:id";
			$criteria_edit->params=array(
				':account_id'=>Yii::app()->session['account_id'],
				':customer_id'=>$customer_id,
				':id'=>$_POST['DependentEdit']['id']
			);
			$edit = Dependent::model()->find($criteria_edit);
			if ($edit != null) {
				$edit->dependent_name=$_POST['DependentEdit']['dependent_name'];
				$edit->dependent_age=$_POST['DependentEdit']['dependent_age'];
				if($edit->update()) {
					Yii::app()->user->setFlash('success', 'Record updated');
				}
			}
		}

		// Show all records related to Criteria
		$criteria_show = new CDbCriteria;
		$criteria_show->condition = "account_id=:account_id AND customer_id=:customer_id";
		$criteria_show->params=array(
			':account_id'=>Yii::app()->session['account_id'],
			':customer_id'=>$customer_id,
		);
		$model = Dependent::model()->findAll($criteria_show);

		$this->render('step_dependents', array('model'=>$model, 'customer'=>$customer));
	}

	public function actionStep_current_coverages()
	{
		if (!isset(Yii::app()->session['customer_id'])) {
			die('Invalid access');
		}
		$customer_id = Yii::app()->session['customer_id'];

		// filter
		$criteria = new CDbCriteria;

		// search customer
		$criteria->condition = "account_id=:account_id AND id=:customer_id";
		$criteria->params=array(
			':account_id'=>Yii::app()->session['account_id'],
			':customer_id'=>$customer_id,
		);
		$customer = Customer::model()->find($criteria);

		// search account setup
		$criteria->condition = "id=:account_id";
		$criteria->params=array(
			':account_id'=>Yii::app()->session['account_id'],
		);
		$account_setup = AccountSetup::model()->find($criteria);
		
		// New record form
		if (isset($_POST['NewForm'])) {
				echo 'joven';exit;
				
				$section = $_POST['NewForm']['section'];
				$saved = false;
				foreach ($_POST['NewForm'][$section] as $key => $value) {
					// Policies in Place
					$piplace = new PoliciesInPlace();
					$piplace->customer_id = $customer_id;
					$piplace->account_id = Yii::app()->session['account_id'];
					$piplace->policy_parent_label = $section;
					$piplace->policy_child_label = $key;
					$piplace->policy_child_selected = $_POST['NewForm'][$section][$key];
					if($piplace->validate()) {
						$piplace->save();
						$this->dd($piplace->errors());
					}

					// Current Coverage
					$model = new CurrentCoverage;
					$model->customer_id = $customer_id;
					$model->account_id = Yii::app()->session['account_id'];
					$model->policy_parent_code = $section;
					$model->policy_child_label = $key;
					$model->policy_child_selected = $_POST['NewForm'][$section][$key];
					if($model->save()){
						$saved = true;
					}else{
						$saved = false;
						break;
					}
				}
				if ($saved) {
					$this->renderJSON(array('status'=>'success', 'json'=> 'Record added'));   
				} else {
					$this->renderJSON($model->getErrors());
				}
				Yii::app()->end();
		}
                
		// Edit record form
		if (isset($_POST['EditForm'])) {
                        foreach($_POST['EditForm'] as $id => $value) {
                            $model = CurrentCoverage::model()->findByPk($id);
                            if ($model != null) {
                                $model->policy_child_selected = $value;
                                if($model->update()){
                                    $this->renderJSON(array('status'=>'success', 'json'=> 'Record updated'));   
                                }else{
                                    $this->renderJSON($model->getErrors());
                                }   
                            } else {
                                $this->renderJSON(array('error'=>'success', 'json'=> 'Item you want to updated does not exist'));
                            }
                            Yii::app()->end();
                        }
		}

		$this->render('step_current_coverages', array(
			'customer'=>$customer,
			'account_setup'=>$account_setup
		));
	}

	public function actionStep_appointment()
	{
		if (!isset(Yii::app()->session['customer_id'])) {
			die('Invalid access');
		}
		$customer_id = Yii::app()->session['customer_id'];

		// filter
		$criteria = new CDbCriteria;

		// search customer
		$criteria->condition = "account_id=:account_id AND id=:customer_id";
		$criteria->params=array(
			':account_id'=>Yii::app()->session['account_id'],
			':customer_id'=>$customer_id,
		);
		$customer = Customer::model()->find($criteria);

		// find account setup details
		$account_setup = AccountSetup::model()->findByPk(Yii::app()->session['account_id']);

		// search existing Appointment
		$criteria->condition = "account_id=:account_id AND customer_id=:customer_id";
		$criteria->params=array(
			':account_id'=>Yii::app()->session['account_id'],
			':customer_id'=>$customer_id,
		);
		$model = Appointment::model()->find($criteria);

		if (isset($_POST['Appointment'])) {
			// delete existing record
			if ($model == null) {
				$model = new Appointment;
				$model->created_at = new CDbExpression('NOW()');
			}
			$model->attributes = $_POST['Appointment'];
			$model->account_id = Yii::app()->session['account_id'];
			$model->customer_id = $customer_id;
			$model->assessment_guid = md5($customer_id);
			if ($model->save()) {
				Yii::app()->user->setFlash('success', 'Appointment updated');
				$this->redirect('step_send_na');
			}
		}

		$this->render('step_appointment', array(
			'customer'=>$customer,
			'account_setup'=>$account_setup,
			'model'=>$model
		));
	}

	public function actionStep_send_na()
	{
		if (!isset(Yii::app()->session['customer_id'])) {
			die('Invalid access');
		}
		$customer_id = Yii::app()->session['customer_id'];
		
		if (isset($_GET['direction'])) {
		    if ($_GET['direction'] == 'next') {
		        Yii::app()->user->setFlash('success', 'Agent Prep Saved');
		        $this->redirect('/customer/listing');
		    }
		}
		
		// filter
		$criteria = new CDbCriteria;

		// search customer
		$criteria->condition = "account_id=:account_id AND id=:customer_id";
		$criteria->params=array(
			':account_id'=>Yii::app()->session['account_id'],
			':customer_id'=>$customer_id,
		);
		$customer = Customer::model()->find($criteria);

		if (isset($_POST['SendTo'])) {
                // Save Meta Key/Value in Database
                self::saveMetaKey();
                
                $verification_sent = null;
                $tmpl = self::NATemplate();
                if ($tmpl == null) {
                    Yii::app()->user->setFlash('error', "No Appointment have set");
                }
                else {					
                    if (isset($_POST['SendTo']['primary'])) {
                        if ($_POST['SendTo']['primary']=="on") {
							// Default
							$sent_to = $customer->primary_email;
							$sent_name = 'Primary Customer';
							$subject = Yii::app()->name . ' - Needs Assessment';
							$email_content = $tmpl['email_content'];
							$from = '';

							// Custom
							if ($tmpl['type'] == 'custom') {
								$from = $tmpl['from'];
								$subject = $tmpl['subject'];
								$email_content = $tmpl['email_content'];
							}
							$sent = $this->sendMail(array(
								'from'=>$from,
								'sent_to'=>$sent_to,
								'sent_name'=>$sent_name,
								'subject'=>$subject,
								'bodyhtml'=>$email_content
							));
							$verification_sent = $sent;
						}
                    }
                    if (isset($_POST['SendTo']['secondary'])) {
                        if ($_POST['SendTo']['secondary']=="on") {
							// Default
							$sent_to =  $customer->secondary_email;
							$sent_name = 'Secondary Customer';
							$subject = Yii::app()->name . ' - Needs Assessment';
							$email_content = $tmpl['email_content'];
							$from = '';

							// Custom
							if ($tmpl['type'] == 'custom') {
								$from = $tmpl['from'];
								$subject = $tmpl['subject'];
								$email_content = $tmpl['email_content'];
							}
							$sent = $this->sendMail(array(
								'from'=>$from,
								'sent_to'=>$sent_to,
								'sent_name'=>$sent_name,
								'subject'=>$subject,
								'bodyhtml'=>$email_content
							));
							$verification_sent = $sent;
						}
                    }
                    
                    if ($verification_sent) {
                        Yii::app()->user->setFlash('success', 'Needs Assessment Verification Email Sent');
                        $this->redirect('/customer/listing');
                    } else {
                        Yii::app()->user->setFlash('error', 'Error on your request');
                    }
                }
		}

		$this->render('step_send_na', array('customer'=>$customer));
	}

	public function NATemplate()
	{

		$account_id = Yii::app()->session['account_id'];
		$customer_id = Yii::app()->session['customer_id'];

		// filter
		$criteria = new CDbCriteria;

		// search customer
		$criteria->condition = "account_id=:account_id AND id=:customer_id";
		$criteria->params=array(
			':account_id'=>$account_id,
			':customer_id'=>$customer_id,
		);
		$customer = Customer::model()->find($criteria);

		// search account setup
		$account_setup = AccountSetup::model()->findByPk($account_id);

		// search appointment
		$criteria->condition = "account_id=:account_id AND customer_id=:customer_id";
		$criteria->params=array(
			':account_id'=>$account_id,
			':customer_id'=>$customer_id,
		);
		$appointment = Appointment::model()->find($criteria);
		if ($appointment != null) {
			$email = $this->programURL() .'/site/access?id='. $customer_id .'&token='.$appointment->assessment_guid;

			// compose remote support link
			$remoteuri = Yii::app()->params['remotesupport'] . base64_encode($appointment->assessment_guid . '-' . $customer_id); 
			$remotesupport = '<a href="'.$remoteuri.'">Start Remote Desktop</a>';

			// Check if theres Custom Template
			// To see parameter check Classes\EnumStatus.php
			$arr = $this->getMailTemplate('NA');
			if ($arr == null) {
				// populating
				$email_content = @file_get_contents($this->programURL().'/template_emails/email_na.html') or die('Cannot open template');
				
				
				// value swapping
				$email_content = str_replace('<customer->primary_firstname>', $customer->primary_firstname, $email_content);
				$email_content = str_replace('<email>', $email, $email_content);
				$email_content = str_replace('<appointment->appointment_date>', date('m/d/Y', strtotime($appointment->appointment_date)), $email_content);
				$email_content = str_replace('<appointment->appointment_time>', $appointment->appointment_time, $email_content);
				$email_content = str_replace('<appointment->location>', $appointment->location, $email_content);
				$email_content = str_replace('<account_setup->office_phone_number>', $account_setup->office_phone_number, $email_content);
				$email_content = str_replace('<applicationLogo>', $this->applicationLogo(EnumLogo::CLIENT), $email_content);
				$email_content = str_replace('<remotesupport>', $remotesupport , $email_content);
				return array(
					'type'=>'default',
					'email_content'=>$email_content,
				);
			} else {
				// populating
				$email_content = $arr['emailcontent'];

				// EnumStatus.php > [cust_pri_fname],[verify_link_na],[apt_date],[apt_time],[apt_location],[apt_office_num],[agency_logo]
				$email_content = str_replace('[cust_pri_fname]', $customer->primary_firstname, $email_content);
				$email_content = str_replace('[verify_link_na]', '<a href="'. $email .'" class="btn-verify">Verify Need Assessment</a>', $email_content);
				$email_content = str_replace('[apt_date]', date('m/d/Y', strtotime($appointment->appointment_date)), $email_content);
				$email_content = str_replace('[apt_time]', $appointment->appointment_time, $email_content);
				$email_content = str_replace('[apt_location]', $appointment->location, $email_content);
				$email_content = str_replace('[apt_office_num]', $account_setup->office_phone_number, $email_content);
				$email_content = str_replace('[remotesupport]', $remotesupport, $email_content);
				return array(
					'type'=>'custom',
					'from'=>$arr['from'],
					'from_name'=>$arr['from_name'],
					'subject'=> $arr['subject'],
					'email_content'=>$email_content,
				);
			}
		} else {
		    return null;
		}
	}

	public function actionIndex()
	{
		// intentionaly blank
	}
        
    /**
     * Save AP Meta
     */
    public function saveMetaKey()
    {
        $criteria = new CDbCriteria;
        
        // Begin: Customer
        $criteria->condition = "account_id=:account_id AND id=:customer_id";
        $criteria->params=array(
            ':account_id'=>Yii::app()->session['account_id'],
            ':customer_id'=>Yii::app()->session['customer_id']
        );
        $action_key = 'AP:Customer';
        $records = Customer::model()->findAll($criteria);
        $this->saveActivity($action_key, CJSON::encode($records));
        // End: Customer
        
        
        $criteria->condition = "account_id=:account_id AND customer_id=:customer_id";
        $criteria->params=array(
            ':account_id'=>Yii::app()->session['account_id'],
            ':customer_id'=>Yii::app()->session['customer_id']
        );
        // Begin: Dependent
        $action_key = 'AP:Dependent';
        $records = Dependent::model()->findAll($criteria);
        $this->saveActivity($action_key, CJSON::encode($records));
        // End: Dependent
        
        // Begin: CurrentCoverage
        $action_key = 'AP:CurrentCoverage';
        $records = CurrentCoverage::model()->findAll($criteria);
        $this->saveActivity($action_key, CJSON::encode($records));
        // End: CurrentCoverage
        
        // Begin: Appointment
        $action_key = 'AP:Appointment';
        $records = Appointment::model()->findAll($criteria);
        $this->saveActivity($action_key, CJSON::encode($records));
        // End: Appointment 
    }
}