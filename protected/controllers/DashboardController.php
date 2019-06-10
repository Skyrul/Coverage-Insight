<?php

class DashboardController extends Controller
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
                        'counter',
	            ),
	            'roles'=>array('admin', 'staff'),
	        ),
	        array('deny',  // deny all users
	            'users'=>array('*'),
	        ),
	    );
	}

	public function actionCounter()
	{
		$criteria=new CDbCriteria;
                
                // Today Appointment 
		$sql = "SELECT count(*) as today_appt FROM tbl_appointment a inner join tbl_customer b on b.id = a.customer_id where a.appointment_date = CURDATE() AND a.account_id = '". Yii::app()->session['account_id'] ."'";
		$cmd = Yii::app()->db->createCommand($sql);
		$results = $cmd->queryAll();
		$today_appt = (int)$results[0]["today_appt"];

                // Sales Opportunites
		$criteria->condition="account_id=:account_id AND is_opportunity = 1";
		$criteria->params=array(
                    ':account_id'=> Yii::app()->session['account_id']
                );                
                $sales_oppt = ActionItem::model()->count($criteria);
                
                // Missing AP
		$criteria->condition = 'account_id=:account_id';
		$criteria->params = array(':account_id'=>Yii::app()->session['account_id']);             
		$customers = Customer::model()->findAll($criteria);
                $appt_missing_ap = 0;
                if (!empty($customers)) {
                    foreach($customers as $k=>$v) {
                        $criteria->condition = 'account_id=:account_id AND customer_id = :customer_id';
                        $criteria->params = array(
                            ':account_id'=>Yii::app()->session['account_id'],
                            ':customer_id'=>$v->id
                        ); 
                        if (Appointment::model()->count($criteria) == 0) {
                            $appt_missing_ap++;
                        }
                    }
                }

                // Future Appointment
		$criteria->condition="account_id=:account_id AND appointment_date > :appointment_date";
		$criteria->params=array(
                    ':account_id'=> Yii::app()->session['account_id'],
                    ':appointment_date'=> date('Y-m-d')
                );                
                $future_appt = Appointment::model()->count($criteria);
                
                // Open Action Items
		$criteria->condition="account_id=:account_id AND is_completed <> 1";
		$criteria->params=array(':account_id'=> Yii::app()->session['account_id']);
                $open_action_item = ActionItem::model()->count($criteria);
                
                
                // Missing NA
		$criteria->condition = 'account_id=:account_id';
		$criteria->params = array(':account_id'=>Yii::app()->session['account_id']);             
		$customers = Customer::model()->findAll($criteria);
                $appt_missing_na = 0;
                if (!empty($customers)) {
                    foreach($customers as $k=>$v) {
                        $criteria->condition = 'account_id=:account_id AND customer_id = :customer_id';
                        $criteria->params = array(
                            ':account_id'=>Yii::app()->session['account_id'],
                            ':customer_id'=>$v->id
                        ); 
                        if (NeedsAssessment::model()->count($criteria) == 0) {
                            $appt_missing_na++;
                        }
                    }
                }
                        
		$this->renderJSON(array(
                    'today_appt'=>$today_appt,
                    'sales_oppt'=>$sales_oppt,
                    'appt_missing_ap'=>$appt_missing_ap,
                    'future_appt'=>$future_appt,
                    'open_action_item'=>$open_action_item,
                    'appt_missing_na'=>$appt_missing_na,
		));
	}

}