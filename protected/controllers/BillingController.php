<?php
class BillingController extends Controller 
{
    public function filters() {
        return array(
            'accessControl',
        );
    }

    public function accessRules() {
        return array(
            array('allow',
                'actions' => array(
                    'save_customer',
                    'payment',
                ),
                'roles' => array(EnumRoles::ADMINISTRATOR, EnumRoles::STAFF),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Actions 
     */
    public function actionSave_customer()
    {
        if (isset($_POST['Customer'])) {
            $form = $_POST['Customer'];
            
            ANETFacade::save_customer(array(
                'description'=>$form['description'],
                'email'=>$form['email']
            ));
        }
    }
    
    public function actionPayment() {

    }
    
    

    
    
}
