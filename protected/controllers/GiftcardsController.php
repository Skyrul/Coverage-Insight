<?php

class GiftcardsController extends Controller
{
	public function actionUpdate()
	{

		$form = $_POST['GiftCards'];

		$model = GiftCards::model()->deleteAll('account_id = :account_id', array(
			':account_id'=> Yii::app()->session['account_id']
		));
		if (!isset($_POST['referralON'])) {
			$model = new GiftCards();
			$model->use_referral = $form['use_referral'];
			$model->i_agree = $form['i_agree'];
			$model->account_id = Yii::app()->session['account_id'];
			$model->offer_enrollment_credit = 1;
			$model->save();
			$this->dd(array(
				'status'=>'success'
			));
		} else {
			$model = new GiftCards();
			$model->use_referral = $form['use_referral'];
			$model->i_agree = $form['i_agree'];
			$model->account_id = Yii::app()->session['account_id'];
			
			// $model->offer_pre_enrollment_credit	 = $form['offer_pre_enrollment_credit'];
			// $model->pre_credit_amounts = $form['pre_credit_amounts'];
			// $model->pre_gift_cards_offer = $form['pre_gift_cards_offer'];

			$model->offer_enrollment_credit = 1; //$form['offer_enrollment_credit'];
			$model->credit_amounts = $form['credit_amounts'];
			$model->gift_cards_offer = $form['gift_cards_offer'];
			$model->save();
			$this->dd(array(
				'status'=>'success'
			));
		}
	}


	public function actionSavecredit()
	{
		$model = new ReferralGC();
		$model->refer_id = $_POST['refer_id'];
		$model->refer_email = $_POST['refer_email'];
		$model->refer_date = new CDbExpression('NOW()');
		$model->gc_amount = $_POST['credit_amount'];
		$model->gc_offer = $_POST['credit_offer'];
		$model->account_id = Yii::app()->session['account_id'];
		if ($model->save()) {
			$this->dd(array(
				'status'=>'success',
				'json'=>'Gift Card record saved'
			));
		} else {
			$this->dd(array(
				'status'=>'error',
				'json'=>$model->errors
			));
		}
	}


}