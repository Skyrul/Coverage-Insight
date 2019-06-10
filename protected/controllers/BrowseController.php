<?php

class BrowseController extends Controller
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
	            	'module',
	            ),
	            'roles'=>array('admin', 'staff'),
	        ),
	        array('deny',  // deny all users
	            'users'=>array('*'),
	        ),
	    );
	}

	public function actionModule()
	{
		if (isset($_GET['id'])) {
			try {
				$id = $_GET['id'];
				if ($id=='customer'){
					$criteria = new CDbCriteria();
                                        $criteria->select = 'id,primary_firstname,primary_lastname,primary_telno,primary_cellphone,primary_alt_telno,primary_address,primary_email,primary_emergency_contact,secondary_firstname,secondary_lastname,secondary_telno,secondary_cellphone,secondary_alt_telno,secondary_address,secondary_email,secondary_emergency_contact';
					$criteria->condition = 'account_id=:account_id';
					$criteria->order = 'primary_firstname DESC';
					$criteria->params = array(':account_id'=>Yii::app()->session['account_id']);
					$records = Customer::model()->findAll($criteria);
					$this->renderJSON(array(
						'status'=>'success',
						'json'=>$records
					));
				}	
			} catch (Exception $e) {
				$this->renderJSON(array(
					'status'=>'error',
					'description'=> $e->getMessage()
				));
			}
		}
	} // actionModule
}