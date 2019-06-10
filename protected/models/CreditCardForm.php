<?php

class CreditCardForm extends CFormModel
{
    public $is_primary;
    public $card_type;
    public $holder;
    public $address;
    public $city;
    public $state;
    public $zip;
    public $cc_number;
    public $cc_expiry_month;
    public $cc_expiry_year;
    public $cc_cvc;
    public $cim_customer_profile_id;
    public $cim_payment_profile_id;
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
			array('created_at, account_id, holder, address, cc_number, cc_expiry_month, cc_expiry_year, card_type, cc_cvc', 'required'),
			array('account_id, is_primary', 'numerical', 'integerOnly'=>true),
			array('cim_customer_profile_id, cim_payment_profile_id', 'length', 'max'=>124),
		    array('cc_number, card_type', 'length', 'max'=>17),
		    array('cc_expiry_year', 'length', 'max'=>4),
		    array('cc_cvc', 'length', 'max'=>4),
		    array('cc_expiry_month', 'length', 'max'=>2),
		);
	}


	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'created_at' => 'Created Date',
		    'account_id' => 'Account Reference',
		    'holder' => 'Name On Card',
		    'cc_number' => 'Credit Card',
		    'card_type' => 'Card Type',
		    'cc_cvc' => 'CVC',
		    'cc_expiry_month' => 'Expiry Month',
		    'cc_expiry_year' => 'Expiry Year',
		    'is_primary' => 'Is Primary',
		    'zip' => 'Zip/Postal Code',
		    'cim_customer_profile_id' => 'Cim Customer Profile',
		    'cim_payment_profile_id' => 'Cim Payment Profile',
		);
	}

}
