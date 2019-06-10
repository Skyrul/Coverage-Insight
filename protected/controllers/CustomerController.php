<?php

class CustomerController extends Controller
{

    public function filters()
    {
        return array(
            'accessControl' // perform access control for CRUD operations
        );
    }

    public function accessRules()
    {
        return array(
            array(
                'allow',
                'actions' => array(
                    'admin',
                    'listing',
                    'create',
                    'delete',
                    'update',
                    'import'
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

    /* Actions */
    public function actionIndex()
    {
        $this->render('index');
    }

    public function actionListing($cmd = 'ALL')
    {
        // init model
        $model = new Customer();
        
        $results = array();
        $criteria_s = new CDbCriteria();
        $criteria = new CDbCriteria();
        
        // Default
        $criteria_s->condition = 'account_id=:account_id';
        $criteria_s->params = array(
            ':account_id' => Yii::app()->session['account_id']
        );
        
        // Sort
        $criteria_s->order = 'created_at DESC';
        
        // Records to Display
        $customers = Customer::model()->findAll($criteria_s);
        
        // Process data for $results
        foreach ($customers as $row) {
            // Next appointment
            $criteria->condition = 'account_id=:account_id AND customer_id=:customer_id';
            $criteria->params = array(
                ':account_id' => Yii::app()->session['account_id'],
                ':customer_id' => $row['id']
            );
            $next_appoinment = Appointment::model()->find($criteria);
            
            // Last_completed_cir
            $criteria->condition = 'account_id=:account_id AND customer_id=:customer_id AND is_completed = 1';
            $criteria->params = array(
                ':account_id' => Yii::app()->session['account_id'],
                ':customer_id' => $row['id']
            );
            $last_completed_cir = CIReview::model()->find($criteria);
            
            // Outstanding action items
            $criteria->condition = 'account_id=:account_id AND customer_id=:customer_id AND is_completed = 0';
            $criteria->params = array(
                ':account_id' => Yii::app()->session['account_id'],
                ':customer_id' => $row['id']
            );
            $outstanding_action_items = ActionItem::model()->count($criteria);
            
            // AP status
            $ap_status = 'btn-norecord';
            if ($row['primary_email'] == null) {
                $ap_status = 'btn-WIP';
            }
            if ($row['primary_email'] != null) {
                $ap_status = 'btn-DONE';
            }
             
            
            // NA status
            $criteria->condition = 'account_id=:account_id AND customer_id=:customer_id AND is_steps_completed = 1';
            $criteria->params = array(
                ':account_id' => Yii::app()->session['account_id'],
                ':customer_id' => $row['id']
            );
            $na_status = 'btn-norecord';
            if ($ap_status == 'btn-DONE') {
                $na_status = 'btn-WIP';
            }
            if (NeedsAssessment::model()->count($criteria) > 0) {
                $na_status = 'btn-DONE';
            }
            
            // CIR status
            $criteria->condition = 'account_id=:account_id AND customer_id=:customer_id AND is_completed = 1';
            $criteria->params = array(
                ':account_id' => Yii::app()->session['account_id'],
                ':customer_id' => $row['id']
            );
            $cir_status = 'btn-norecord';
            if ($na_status == 'btn-DONE') {
                $cir_status = 'btn-WIP';
            }
            if (CIReview::model()->count($criteria) > 0) {
                $cir_status = 'btn-DONE';
            }
            
            // Composed data
            $data = array(
                'id' => ($row['id']),
                'fname' => ($row['primary_firstname']),
                'lname' => ($row['primary_lastname']),
                'next_appoinment' => ($next_appoinment != null) ? date('m/d/Y', strtotime($next_appoinment->appointment_date)) : '',
                'last_completed_cir' => ($last_completed_cir != null) ? date('m/d/Y', strtotime($last_completed_cir->ci_review_date)) : '',
                'outstanding_action_items' => $outstanding_action_items,
                'ap_status' => $ap_status,
                'na_status' => $na_status,
                'cir_status' => $cir_status
            );
            
            // Condition Filter
            switch ($cmd) {
                case 'MISSING_AP':
                    if ($data['next_appoinment'] == '') {
                        array_push($results, $data);
                    }
                    break;
                case 'MISSING_NA':
                    if ($na_status == false) {
                        array_push($results, $data);
                    }
                    break;
                case 'FUTURE_APPOINTMENT':
                    if ($data['next_appoinment'] !== '') {
                        $date_today = date('Y-m-d');
                        $nxt_appt = date('Y-m-d', strtotime($next_appoinment->appointment_date));
                        if ($nxt_appt > $date_today) {
                            array_push($results, $data);
                        }
                    }
                    break;
                case 'TODAY_APPOINTMENT':
                    if ($data['next_appoinment'] !== '') {
                        $date_today = date('Y-m-d');
                        $nxt_appt = date('Y-m-d', strtotime($next_appoinment->appointment_date));
                        if ($date_today == $nxt_appt) {
                            array_push($results, $data);
                        }
                    }
                    break;
                default:
                    array_push($results, $data);
                    break;
            }
        }
        $this->render('listing', array(
            'results' => $results,
            'model' => $model
        ));
    }

    public function actionUpdate()
    {
        if (isset($_POST['Customer'])) {
            $i = $_POST['Customer'];
            
            $cr = new CDbCriteria();
            $cr->condition = 'id = :id AND account_id = :account_id';
            $cr->params = array(
                ':id'=> $i['Id'],
                ':account_id'=> Yii::app()->session['account_id'],
            );
            $model = Customer::model()->find($cr);
            if ($model != null) {
                $model->primary_firstname = $i['data0'];
                $model->primary_lastname  = $i['data1'];
                $model->save();
                
                $this->logText("fname/lname:". $i['data0'] . ", action: update");
                
                $this->dd(array(
                    'status'=>'success',
                    'json'=>'Customer updated'
                ));
            }
        }
    }
    
    public function actionDelete($id = null)
    {
        $model = Customer::model()->findByPk($id);
        $model->delete();
        
        $this->logText("customer:". $id . ", account:". Yii::app()->session['account_id'] .", action: delete");
        
        Yii::app()->user->setFlash('notice', 'Record deleted');
        $this->redirect(array(
            'customer/listing'
        ));
    }

    public function actionImport()
    {   
        ini_set('memory_limit', '512M'); 
        set_time_limit(0);
        $back_to_main = '<a href="'. $this->programURL() .'/customer/listing">Back to listing</a>';
        $uploaded = false;
        $excelfile = '';
        if(isset($_FILES["file"]["error"])) {
            if($_FILES["file"]["error"] > 0) {
                echo "Error: " . $_FILES["file"]["error"] . "<br>";
            } else{
                $allowed = array(
                    "xls" => array( "application/vnd.ms-excel" ),
                    "xlsx" => array(
                        "application/vnd.ms-excel",
                        "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                    )
                );
                $filename = $_FILES["file"]["name"];
                $filetype = $_FILES["file"]["type"];
                $filesize = $_FILES["file"]["size"];
                $filetmp  = $_FILES["file"]["tmp_name"];
                
                // Allowed Extension
                $ext = pathinfo($filename, PATHINFO_EXTENSION);
                if(!array_key_exists($ext, $allowed)) die("Error: This file is not an accepted file type.</br></br>".$back_to_main);
                
                // Allowed Filesize 10MB
                $maxsize = 200000 * 60;
                if($filesize > $maxsize) die("Error: File size is larger than the allowed 10MB limit.</br></br>".$back_to_main);
                
                if ( isset( $allowed[$ext] ) && in_array( $filetype, $allowed[$ext] ) ) {
                    $excelpath = sys_get_temp_dir() . '/tp_';
                    $excelfile = $excelpath . $_FILES["file"]["name"];
                    // Check whether file exists before uploading it
                    if(file_exists($excelfile)){
                        //echo $_FILES["file"]["name"] . " already exists. Go back and choose another file.</br></br>".$back_to_main;
                        unlink($excelfile);
                    }
                    move_uploaded_file($filetmp, $excelfile);
                    //echo "The file was uploaded successfully.</br></br>";
                    $uploaded = true;
                }
                else{
                    echo "Error: There was a problem uploading the file - please try again.".$back_to_main;
                }
            }
            
            // Read uploaded Excel
            if ($uploaded == true) {
                $sheet_array = Yii::app()->yexcel->readActiveSheet($excelfile);
                $imported = false;
                $row_ctr = 1;
                foreach( $sheet_array as $row ):
                    // Skip first header
                    if ($row_ctr > 1):
                        // Insert Customer Detail
                        $customer = new Customer();
                        $customer->account_id = Yii::app()->session['account_id'];
                        foreach( $row as $k=>$column ):
                                switch($k) {
                                    case 'A':
                                        $customer->primary_firstname = $column;
                                        break;
                                    case 'B':
                                        $customer->primary_lastname = $column;
                                        break;
                                    case 'C':
                                        $customer->primary_telno = $column;
                                        break;
                                    case 'D':
                                        $customer->primary_cellphone = $column;
                                        break;
                                    case 'E':
                                        $customer->primary_alt_telno = $column;
                                        break;
                                    case 'F':
                                        $customer->primary_email = $column;
                                        break;
                                    case 'G':
                                        $customer->primary_emergency_contact = $column;
                                        break;
                                    case 'H':
                                        $customer->secondary_firstname = $column;
                                        break;
                                    case 'I':
                                        $customer->secondary_lastname = $column;
                                        break;
                                    case 'J':
                                        $customer->secondary_telno = $column;
                                        break;
                                    case 'K':
                                        $customer->secondary_cellphone = $column;
                                        break;
                                    case 'L':
                                        $customer->secondary_alt_telno = $column;
                                        break;
                                    case 'M':
                                        $customer->secondary_email = $column;
                                        break;
                                    case 'N':
                                        $customer->secondary_emergency_contact = $column;
                                        break;
                                }
                        endforeach;
                        $customer->save();
                        // End: Inserting of Customer
                
                        // Get Last Inserted Id
                        $customer_id = $customer->id;
                        
                        // Insert the Dependents
                        $ctr = 0;
                        for ($ctr = 1;$ctr <= 6; $ctr++) {                            
                            // Dependent 1
                            if ($ctr == 1)
                            {
                                $dependent = new Dependent();
                                $dependent->customer_id = $customer_id;
                                $dependent->account_id = Yii::app()->session['account_id'];
                                foreach( $row as $k=>$column ) {
                                    switch($k) {
                                        case 'O':
                                            $dependent->dependent_name = $column;
                                            break;
                                        case 'P':
                                            $dependent->dependent_age = $column;
                                            break;
                                    }
                                }
                                $dependent->save();
                            }
                            
                            // Dependent 2
                            if ($ctr == 2)
                            {
                                $dependent = new Dependent();
                                $dependent->customer_id = $customer_id;
                                $dependent->account_id = Yii::app()->session['account_id'];
                                foreach( $row as $k=>$column ) {
                                    switch($k) {
                                        case 'Q':
                                            $dependent->dependent_name = $column;
                                            break;
                                        case 'R':
                                            $dependent->dependent_age = $column;
                                            break;
                                    }
                                }
                                $dependent->save();
                            }
                            
                            // Dependent 3
                            if ($ctr == 3)
                            {
                                $dependent = new Dependent();
                                $dependent->customer_id = $customer_id;
                                $dependent->account_id = Yii::app()->session['account_id'];
                                foreach( $row as $k=>$column ) {
                                    switch($k) {
                                        case 'S':
                                            $dependent->dependent_name = $column;
                                            break;
                                        case 'T':
                                            $dependent->dependent_age = $column;
                                            break;
                                    };
                                }
                                $dependent->save();
                            }
                            
                            // Dependent 4
                            if ($ctr == 4)
                            {
                                $dependent = new Dependent();
                                $dependent->customer_id = $customer_id;
                                $dependent->account_id = Yii::app()->session['account_id'];
                                foreach( $row as $k=>$column ) {
                                    switch($k) {
                                        case 'U':
                                            $dependent->dependent_name = $column;
                                            break;
                                        case 'V':
                                            $dependent->dependent_age = $column;
                                            break;
                                    }
                                }
                                $dependent->save();
                            }
                            
                            // Dependent 5
                            if ($ctr == 5)
                            {
                                $dependent = new Dependent();
                                $dependent->customer_id = $customer_id;
                                $dependent->account_id = Yii::app()->session['account_id'];
                                foreach( $row as $k=>$column ) {
                                    switch($k) {
                                        case 'W':
                                            $dependent->dependent_name = $column;
                                            break;
                                        case 'X':
                                            $dependent->dependent_age = $column;
                                            break;
                                    }
                                }
                                $dependent->save();
                            }
                            
                            // Dependent 6
                            if ($ctr == 6)
                            {
                                $dependent = new Dependent();
                                $dependent->customer_id = $customer_id;
                                $dependent->account_id = Yii::app()->session['account_id'];
                                foreach( $row as $k=>$column ) {
                                    switch($k) {
                                        case 'Y':
                                            $dependent->dependent_name = $column;
                                            break;
                                        case 'Z':
                                            $dependent->dependent_age = $column;
                                            break;
                                    }
                                }
                                $dependent->save();
                            }
                            
                            
                        }
                        // End: Inserting of Dependents
                        
                    endif; // End: Skip first header
                
                
                    
                    // Row Counter
                    $row_ctr++;
                endforeach;
                
                Dependent::model()->deleteAll("account_id = :account_id AND dependent_name is null", array(':account_id'=>Yii::app()->session['account_id']));
                
                $imported = true;
                if ($imported) {
                    Yii::app()->user->setFlash('success', 'Excel File Successfully Uploaded.');
                    $this->redirect('/customer/listing');
                } else {
                    echo 'Please Check and Validate Your Excel Format, Then Try Again. <br><br> Download this <a href="'. $this->programURL() .'/uploads/excel-format.xlsx">Sample Format.</a>';
                }
            }
            // End: Read Excel
        } else {
            echo "Error: Invalid parameters - something is very very very wrong with this upload.".$back_to_main;
        }
        
        
    }
    
    /**
     * Performs the AJAX validation.
     * 
     * @param Feedback $model
     *            the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'customer-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
