<?php

class FeedbackController extends AdminBaseController
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
		$this->renderPartial('view',array(
			'model'=>$this->loadModel($id),
		));
	}
	
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
	    $model=$this->loadModel($id);
	    
	    // Uncomment the following line if AJAX validation is needed
	    // $this->performAjaxValidation($model);
	    
	    if(isset($_POST['Feedback']))
	    {
	        $model->attributes=$_POST['Feedback'];
			if($model->save()):
				if ($model->status == 'REVIEW') {
					$feedback_id = $this->programURL().'/feedback/view/'. $model->id;
					$this->sendMail(array(
						'sent_to'=>$model->reporter_email,
						'sent_name'=>$model->reporter_email,
						'subject'=>'Your Feedback Item Ready for Review',
						'bodyhtml'=>'Engagex Developer: Changed status of Feedback Item: '. $feedback_id
					));
				}
	            $this->redirect(array('index'));
				//$this->redirect(array('view','id'=>$model->id));
			endif;
	    }
	    
	    $this->render('update',array(
	        'model'=>$model,
	    ));
	}
	

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
		    Yii::app()->user->setFlash('success', 'Item deleted');
		    $this->redirect(array('index'));
			//$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$criteria = new CDbCriteria();
		$criteria->condition = 'id <> 0'; // default

		if (isset($_POST['tfilter'])) {
			$status = CHtml::encode($_POST['tfilter']);
			if ($status != 'ALL') {
				$criteria->condition = "status = :status";
				$criteria->params = array(
					':status'=>$status
				);
			}
		}

	    $dataProvider=new CActiveDataProvider('Feedback', array(
	        'sort'=>array(
	            'defaultOrder'=>'id DESC',
			),
			'pagination'=>false,
			'criteria'=>$criteria,
	    ));
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
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
		if($model===null) {
			//throw new CHttpException(404,'The requested page does not exist.');
		}
			
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Feedback $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='feedback-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
