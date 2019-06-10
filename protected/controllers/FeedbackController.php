<?php

class FeedbackController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	//public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
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
				'actions'=>array('index','view','viewall', 'changestatus', 'thank_you'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
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
			'model'=>Feedback::model()->find('id = :feedback_id', array(':feedback_id'=>$id)),
			'attachments'=> FeedbackAttachment::model()->findAll('feedback_id=:id', array(':id'=>$id))
		));
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionViewall()
	{
		$criteria = new CDbCriteria;
		$criteria->condition = 'account_id = :account_id';
		$criteria->params = array(
			':account_id'=> Yii::app()->session['account_id']
		);
		$criteria->order = 'id DESC';
		$this->render('viewall',array(
			'model'=>Feedback::model()->findAll($criteria),
		));
	}

	public function actionChangestatus($id=null, $status=null) 
	{
		if ($id != null && $status != null){
			$white = array('open', 'close', 'pending');
			if (!in_array($status, $white)) {
				echo 'invalid';
				exit;
			}
			$model = Feedback::model()->find('id=:id', array(
				':id'=>$id
			));
			$status = strtoupper($status);
			if ($model != null) {
				$model->status = $status;
				$model->save();
				$this->sendMail(array(
					'sent_to'=>'joven.barola@engagex.com',
					'sent_name'=>'Developer',
					'subject'=>'Feedback Status Changed',
					'bodyhtml'=>'Feedback Item('. $model->id .') Changed Status to '. $status,
				));

				$this->redirect(Yii::app()->request->urlReferrer);
			}
		}
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Feedback;

		if(isset($_POST['Feedback']))
		{
			$model->attributes=$_POST['Feedback'];
			$model->reporter_name=Yii::app()->user->name;
			$model->created_at = new CDbExpression('NOW()');
			$model->account_id = Yii::app()->session['account_id'];
			$fimage = CUploadedFile::getInstance($model, 'image');
			if($model->validate()) {
				// echo json_encode($model->attributes);
				$model->save();
				if (!empty($fimage)){
					$imagepath = YiiBase::getPathOfAlias("webroot.feedback");
					$filename = "{$model->id}_{$fimage}";
					$fimage->saveAs($imagepath.'/'. $filename);
					$fat = new FeedbackAttachment;
					$fat->account_id = Yii::app()->session['account_id'];
					$fat->feedback_id = $model->id;
					$fat->attachment = $filename;
					$fat->save();
				}
				$this->dd(array(
					'status'=>'success',
					'json'=>'Thank you for this feedback!'
				));
				exit;
			} else {
				$this->dd(array(
					'status'=>'error',
					'json'=>CHtml::errorSummary($model, '', '')
				));
			}
		}

		$this->layout = '//layouts/blank';
		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionThank_you()
	{
		$this->layout = '//layouts/blank';
		$this->render('thank_you');
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
//		 $this->performAjaxValidation($model);

		if(isset($_POST['Feedback']))
		{
			$model->attributes=$_POST['Feedback'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
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
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Feedback');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Feedback('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Feedback']))
			$model->attributes=$_GET['Feedback'];

		$this->render('admin',array(
			'model'=>$model,
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='feedback-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
