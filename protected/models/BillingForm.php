<?php

/**
 * @property string $credit_card
 * @property string $next_billing
 * @property string $invoice_no
 * @property string $promo_code
 * @property string $status
 * @property string $description
 * @property string $created_at
 * @property integer $account_id
 */
class BillingForm extends CFormModel
{

    public $credit_card;
    public $next_billing;
    public $invoice_type;
    public $cim_customer_profile_id;
    public $invoice_no;
    public $promo_code;
    public $status;
    public $description;
    public $created_at;
    public $account_id;
    
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('credit_card, status, description, account_id, invoice_type', 'required'),
			array('account_id', 'numerical', 'integerOnly'=>true),
			array('created_at', 'safe'),
		    
		    // max length
		    array('promo_code', 'length', 'max'=>5),
		    
		    // promo custom validator
		    array('promo_code', 'promoExists'),
		    array('promo_code', 'promoExpired'),
		    array('promo_code', 'promoAlreadyUsed'),
		    
		    // only pay an Unpaid invoice
		    array('invoice_no', 'invoiceUnpaidOnly'),
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
	
	public function promoAlreadyUsed($attribute, $params)
	{
	    if ($this->promo_code != null) {
	        // check if expired
	        $promo = Payments::model()->find('promo_code=:promo_code AND account_id = :account_id', array(
	            ':promo_code'=>$this->promo_code,
	            ':account_id'=>Yii::app()->session['account_id'],
	        ));
	        if($promo != null) {
	            $this->addError($attribute, 'You already used this Promo Code');
	        }
	        
	    }
	}
	
	public function invoiceUnpaidOnly($attribute, $params)
	{
	    if ($this->invoice_no != null) {
	        // only unpaid invoice to process
	        $invoice = Billing::model()->find('bill_no=:bill_no AND bill_status = :bill_status', array(
	            ':bill_no'=>$this->invoice_no,
	            ':bill_status'=>EnumStatus::PAID,
	        ));
	        if($invoice != null) {
	            $this->addError($attribute, 'Invoice already paid');
	        }
	    }
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'credit_card' => 'Credit Card',
			'next_billing' => 'Next Billing',
		    'cim_customer_profile_id' => 'Customer Profile ID',
		    'invoice_type' => 'Invoice Type',
			'invoice_no' => 'Invoice Number',
			'promo_code' => 'Promo Code',
			'status' => 'Status',
			'description' => 'Description',
			'created_at' => 'Date Posted',
			'account_id' => 'Account',
		);
	}

	
}
