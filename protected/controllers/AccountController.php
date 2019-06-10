<?php
class AccountController extends Controller 
{
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    public function accessRules() {
        return array(
            array('allow',
                'actions' => array(
                    'action_item',
                    'setup',
                    'resource_upload',
                ),
                'roles' => array('admin', 'staff'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Actions 
     */
    public function actionSetup() {
        // init active form model
        $info = new InfoForm;
        $logo = new LogoForm;
        $changepass = new PasswordForm;
        $emailsetting = new EmailForm;
        $listing = new ListingForm;
        $colour = new ColourForm;
        $billingform = new BillingForm();
        $emailtemplate = new EmailTemplate();

        $criteria = New CDbCriteria;
        
        // Insert Year/Make/Model if doesnt exist
        $fixedrec = array(
            'Year',
            'Make',
            'Model'
        );
        foreach($fixedrec as $k => $v) {
            $addrec = AccountSetupPolicy::model()->find('account_id=:account_id AND policy_child_label = :policy_child_label',array(
                ':account_id' => Yii::app()->session['account_id'],
                ':policy_child_label' => $v
            ));
            if ($addrec == null) {
                $yr = new AccountSetupPolicy;
                $yr->policy_parent_label = 'Auto';
                $yr->policy_child_label = $v;
                $yr->policy_child_questions = $v;
                $yr->is_child_checked = 1;
                $yr->account_id = Yii::app()->session['account_id'];
                $yr->save();
            }   
        }
        
        
        /** ORM Queries **/
        // Account Setup
        $acctsetup = AccountSetup::model()->find('id=:account_id', array(':account_id' => Yii::app()->session['account_id']));
        
        // Policies
        $criteria->condition = 'account_id=:account_id';
        $criteria->params = array(':account_id' => Yii::app()->session['account_id']);
        $criteria->order = 'order_id ASC';
        $policies = AccountSetupPolicy::model()->findAll($criteria);
        
        // Security Group
        $security_group = SecurityGroup::model()->findAll('account_id = :account_id', array(
            ':account_id'=>Yii::app()->session['account_id']
        ));
        
        // Staff Management
        $staff = User::model()->findAll('account_id = :account_id AND roles = :roles', array(
            ':account_id'=>Yii::app()->session['account_id'],
            ':roles'=>EnumRoles::STAFF,
        ));
        
        // Colors
        $colors = ColourScheme::model()->findByPk($acctsetup->colour_scheme_id);
        if ($colors == null) {
            $colors = ColourScheme::model()->findByPk(1);
        } else {
            if ($colors->scheme_name == 'Custom') {
                $colors = ColourCustom::model()->find('account_id=:account_id', array(':account_id' => Yii::app()->session['account_id']));
            }
        }
        
        // Credit Cards
        $criteria_cc = new CDbCriteria();
        $criteria_cc->condition = 'account_id = :account_id';
        $criteria_cc->params = array(
            ':account_id'=>Yii::app()->session['account_id']
        );
        $criteria_cc->order = 'is_primary DESC'; // first show the set as primary card
        $credit_cards = CreditCardSettings::model()->findAll($criteria_cc);
        
        // Gift Cards
        $giftcards = GiftCards::model()->find('account_id = :account_id', array(
            ':account_id'=>Yii::app()->session['account_id']
        ));
        if ($giftcards == null) {
            $giftcards = new GiftCards();
        }

        // Email Template
        $emailtemplates = EmailTemplate::model()->findAll('account_id = :account_id',array(
            ':account_id'=>Yii::app()->session['account_id'],
        ));
        
        $this->render('setup', array(
            'info' => $info,
            'security_group' => $security_group,
            'staff'=>$staff,
            'logo' => $logo,
            'changepass' => $changepass,
            'emailsetting' => $emailsetting,
            'listing' => $listing,
            'policies' => $policies,
            'acctsetup' => $acctsetup,
            'colour' => $colour,  // selected color
            'colors' => $colors,  // lists of colors
            'billingform' => $billingform,
            'credit_cards'=>$credit_cards,
            'giftcards'=> $giftcards,
            'emailtemplate'=> $emailtemplate,
            'emailtemplates'=> $emailtemplates,
        ));
    }

    public function actionAction_item($cmd='ALL') {
        // Default Query
        $condition = 'a.account_id=:account_id';
        $params = array(':account_id' => Yii::app()->session['account_id']);
        
        switch($cmd) { 
            case 'OPEN_ACTION_ITEMS':
                if (isset($_GET['customer_id'])) {
                    $condition = 'a.account_id=:account_id AND a.customer_id=:customer_id';
                    $params = array(
                        ':account_id' => Yii::app()->session['account_id'],
                        ':customer_id' => $_GET['customer_id']
                    );
                } else {
                    $condition = 'a.account_id=:account_id AND a.is_completed = 0';
                    $params = array(
                        ':account_id' => Yii::app()->session['account_id']
                    );   
                }
                break;
            
            case 'OPEN_ACTION_ITEM_BY':
                if (isset($_GET['customer_id'])) {
                    $condition = 'a.account_id=:account_id AND a.customer_id=:customer_id AND a.is_completed = 0';
                    $params = array(
                        ':account_id' => Yii::app()->session['account_id'],
                        ':customer_id' => $_GET['customer_id']
                    );
                }
                break;
            case 'SALES_OPPORTUNITIES':
                $condition = 'a.account_id=:account_id AND a.is_opportunity = 1';
                $params = array(
                    ':account_id' => Yii::app()->session['account_id']
                );
                break;
        }

        $records = Yii::app()->db->createCommand()
                ->select('a.*, c.primary_firstname, c.primary_lastname, c.secondary_firstname, c.secondary_lastname')
                ->from('tbl_action_item a')
                ->leftJoin('tbl_customer c', 'a.customer_id = c.id')
                ->where($condition, $params)
                ->queryAll();

        // process data for $results
        $results = array();
        foreach ($records as $row) {
            array_push($results, array(
                'id' => $row['id'],
                'customer_id' => $row['customer_id'],
                'is_opportunity' => $row['is_opportunity'],
                'is_completed' => $row['is_completed'],
                'customer_primary_fname' => $row['primary_firstname'] . ' ' . $row['primary_lastname'],
                'customer_secondary_fname' => $row['secondary_firstname'] . ' ' . $row['secondary_lastname'],
                'owner' => $row['owner'],
                'description' => $row['description'],
                'created_date' => $row['created_date'],
                'due_date' => $row['due_date'],
            ));
        }

        // init model
        $model = new ActionItem;
        $this->render('action_item', array('model' => $model, 'results' => $results));
    }
    
    public function actionResource_upload($itype='none') 
    {
        $this->layout = '//layouts/blank';
        $this->page_label = "Resource Upload - " . $itype;
        $this->render('resource_upload', array('insurance_type'=>$itype));
    }
    
}
