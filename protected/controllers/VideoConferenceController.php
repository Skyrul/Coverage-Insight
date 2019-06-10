<?php

class VideoConferenceController extends Controller {

    public function actionGenerate($customer_id = 0)
    {
        $model = new Videoconference();
        
        if (isset($_POST['Videoconference'])) {
            $form = $_POST['Videoconference'];
            // $this->dd($form);
            $model->customer_id = $customer_id;
            $model->account_id = Yii::app()->session['account_id'];
            $model->created_at = new CDbExpression('NOW()');

            $model->sched_date = date('Y-m-d', strtotime($form['sched_date']));
            $model->sched_time = $form['sched_time'];
            $model->remarks = $form['remarks'];
            //$generated_url = $this->programURL() . '/videoConference/start?customer_id='. $customer_id . '&date='. $model->sched_date . '&time=' . $model->sched_time;
            $verification_code = com_create_guid(); //base64_encode($generated_url);
            $verification_code = base64_encode($verification_code);
            $generated_url = '?verification_code=' . $verification_code;
            $model->generated_url = $generated_url;
            $model->verification_code = $verification_code;
            $model->status = 'created';
            if($model->validate()) {
                $model->save();
                Yii::app()->user->setFlash('success', 'Video Conference Schedule are now saved');
                $this->redirect($this->getCurrentURL());
            }
        }
        
        // get records
        $criteria = new CDbCriteria();
        $criteria->condition = 'customer_id = :customer_id AND account_id = :account_id';
        $criteria->params = array(
            ':customer_id'=>$customer_id,
            ':account_id'=>Yii::app()->session['account_id'],
        );
        $criteria->order = 'id DESC';
        $record = Videoconference::model()->findAll($criteria);

        // search for customer record
        $customer = Customer::model()->find('id = :customer_id', array(
            ':customer_id'=> $customer_id
        ));

        // search for appointment
        $appointment = Appointment::model()->find('customer_id = :customer_id AND account_id = :account_id', array(
            ':customer_id'=>$customer_id,
            ':account_id'=>Yii::app()->session['account_id']
        ));

        $this->render('generate', array(
            'customer_id'=> $customer_id,
            'customer'=> $customer,
            'appointment'=> $appointment,
            'model'=> $model,
            'record'=> $record,
        ));
    }

    public function actionStatusdone($id = '', $customer_id) 
    {
        $model = Videoconference::model()->find('id=:id AND account_id=:account_id', array(
            ':id'=>$id,
            ':account_id'=>Yii::app()->session['account_id'],
        ));
        if ($model != null) {
            $model->status = 'done';
            $model->update();
            Yii::app()->user->setFlash('success', 'Conference status updated');
        }
        $this->redirect($this->programURL().'/videoConference/generate?customer_id='. $customer_id);
    }

    public function actionAgencyviewer($verification_code = '') 
    {
        $model = Videoconference::model()->find('verification_code=:verification_code', array(
            ':verification_code'=>$verification_code
        ));
        if ($model != null) {
            $customer = Customer::model()->find('id=:customer_id', array(':customer_id'=>$model->customer_id));
            $account_setup = AccountSetup::model()->find('id=:account_id', array(':account_id'=>$model->account_id));
            $appointment = Appointment::model()->find('customer_id = :customer_id AND account_id = :account_id', array(
                ':customer_id'=>$model->customer_id,
                ':account_id'=>$model->account_id
            ));
            
            $this->render('agencyviewer', array(
                'model'=>$model,
                'customer'=>$customer,
                'account_setup'=>$account_setup,
                'appointment'=>$appointment
            ));
        } else {
            $this->dd('invalid');
        }
    }

    public function actionCustomerviewer($verification_code = '') 
    {
        $model = Videoconference::model()->find('verification_code=:verification_code', array(
            ':verification_code'=>$verification_code
        ));
        if ($model != null) {
            $customer = Customer::model()->find('id=:customer_id', array(':customer_id'=>$model->customer_id));
            $account_setup = AccountSetup::model()->find('id=:account_id', array(':account_id'=>$model->account_id));
            $appointment = Appointment::model()->find('customer_id = :customer_id AND account_id = :account_id', array(
                ':customer_id'=>$model->customer_id,
                ':account_id'=>$model->account_id
            ));

            $this->layout = 'column_videoconference';
            $this->render('customerviewer', array(
                'model'=>$model,
                'customer'=>$customer,
                'account_setup'=>$account_setup,
                'appointment'=>$appointment
            ));
        } else {
            $this->dd('invalid');
        }
    } 
}