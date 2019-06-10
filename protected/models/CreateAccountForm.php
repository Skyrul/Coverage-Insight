<?php
class CreateAccountForm extends CFormModel
{

    public $agency_name;
    public $first_name;
    public $last_name;
    public $email;
    public $password;
    public $confirm_password;
    public $cc_cardnum;
    public $cc_cardname;
    public $cc_cardtype;
    public $cc_expiry_month;
    public $cc_expiry_year;
    public $cc_cvc;
    public $bill_address;
    public $bill_city;
    public $bill_state;
    public $bill_zipcode;
    public $bill_phone;
	public $buy_staff;
	public $videoconf_feature;
    public $promo_code;
    public $agree_form;
    
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
	    Yii::import('ext.validators.ECCValidator');
	    
		return array(
		    // required
			array('password, confirm_password, email, agency_name, first_name, last_name, cc_cardnum, cc_cardname, cc_cardtype, cc_expiry_month, cc_expiry_year, cc_cvc, bill_address, bill_city, bill_state, bill_zipcode, agree_form', 'required'),
		    
		    // built-in validator
		    array('email', 'email'),
		    array('cc_cvc', 'numerical'),
		    
		    // custom validator
		    array('cc_cardnum', 'ext.validators.ECCValidator', 'format'=>array(ECCValidator::ALL)),
		    array('promo_code', 'promoExists'),
		    array('promo_code', 'promoExpired'),
		    array('confirm_password', 'compare', 'compareAttribute'=>'password', 'message'=>'Password dont match'),
		    
		    // max length
			array('password, email, bill_address', 'length', 'max'=>128),
		    array('cc_cardname, bill_city, bill_state, bill_zipcode', 'length', 'max'=>124),
		    array('cc_cardnum, bill_phone', 'length', 'max'=>60),
		    array('promo_code', 'length', 'max'=>5),
		    array('cc_expiry_year', 'length', 'max'=>4),
		    array('cc_cvc', 'length', 'max'=>4),
		    array('cc_expiry_month', 'length', 'max'=>2),
		    
		    
		);
	}
	
	public function promoExists($attribute, $params)
	{
	    if ($this->promo_code != null) {
	        // only active promo
	        $promo = Promo::model()->find('promo_code=:promo_code AND status = :status', array(
	            ':promo_code'=>$this->promo_code,
	            ':status'=>EnumStatus::ACTIVE,
	        ));
	        if($promo == null) {
	            $this->addError($attribute, 'Promo Not Exists');
	        }
	    }
	}
	
	public function promoExpired($attribute, $params)
	{
	    if ($this->promo_code != null) {
	        // check if expired
	        $promo = Promo::model()->find('promo_code=:promo_code AND status = :status AND promo_end < CURDATE()', array(
	            ':promo_code'=>$this->promo_code,
	            ':status'=>EnumStatus::ACTIVE,
	        ));
	        if($promo != null) {
	            $this->addError($attribute, 'Promo Already Expired');
	        }
	            
	    }
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'username' => 'Username',
			'password' => 'Password',
		    'confirm_password' => 'Confirm Password',
		    'first_name' => 'First Name',
		    'last_name' => 'Last Name',
			'email' => 'Email',
			'roles' => 'Roles',
		    'cc_cardnum' => 'Card Number',
		    'cc_cardname' => 'Name on Card',
		    'cc_cardtype' => 'Card Type',
		    'cc_expiry_month' => 'Month',
		    'cc_expiry_year' => 'Year',
		    'cc_cvc' => 'CVC',
		    'bill_address' => 'Billing Address',
		    'bill_city' => 'Billing City',
		    'bill_state' => 'Billing State',
		    'bill_zipcode' => 'Billing ZIP/Postal Code',
		    'bill_phone' => 'Billing Phone',
			'buy_staff'  => 'Buy Staff',
			'videoconf_feature'  => 'Video Conference Feature',
		    'agree_form' =>'** To proceed you need to Agree on Terms of Service **',
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
