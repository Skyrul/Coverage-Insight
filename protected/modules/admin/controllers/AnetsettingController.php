<?php

class AnetsettingController extends AdminBaseController
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
		    array('allow', // allow authenticated user to perform 'update' action
				'actions'=>array( 'update'),
		        'roles'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}


	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate()
	{
	    
	    $anet = AnetConfig::model()->find();
	    if ($anet == null) {
	        echo 'No record for Authorize.net, manually add this to database';
	        exit;
	    }
	    $id = $anet->id;
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['AnetConfig']))
		{
			$model->attributes=$_POST['AnetConfig'];
			if($model->save())
			    $this->redirect($this->getCurrentURL());
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('ChargesFee');
		$this->render('index',array(
		      'dataProvider'=>$dataProvider,
		));
	}


	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return ChargesFee the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
	    $model=AnetConfig::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param ChargesFee $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='anetsetting-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
