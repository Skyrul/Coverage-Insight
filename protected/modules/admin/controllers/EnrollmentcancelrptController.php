<?php

class EnrollmentcancelrptController extends AdminBaseController
{

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
			    'actions'=>array('create','update','delete'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}
	

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
	    
	    $criteria = new CDbCriteria();
	    if (isset($_POST['FormFilter'])) {
	        $form = $_POST['FormFilter'];
	        $start_date = date('Y-m-d', strtotime($form['start_date']));
	        $end_date = date('Y-m-d', strtotime($form['end_date']));
	        
	        // superuser no account_id filter
	        if ($form['invoice_type'] == 'ALL') {
	            $criteria->condition = 'created_at BETWEEN :start_date AND :end_date';
	            $criteria->params = array(
	                ':start_date'=>$start_date,
	                ':end_date'=>$end_date,
	            );
	        } else {
	            $criteria->condition = 'invoice_type = :invoice_type AND payment_date BETWEEN :start_date AND :end_date';
	            $criteria->params = array(
	                ':start_date'=>$start_date,
	                ':end_date'=>$end_date,
	                ':invoice_type'=>$form['invoice_type'],
	            );
	        }
	        $criteria->order = 'id DESC';
	        
	    } else {
	        $criteria->condition = 'account_id = 0';
	        $criteria->order = 'id DESC';
	    }
	    
	    // execute filter
	    $records = Payments::model()->findAll($criteria);
	    
		$this->render('index',array(
		    'records'=>$records,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Feedback the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Feedback::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Feedback $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='billing-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
