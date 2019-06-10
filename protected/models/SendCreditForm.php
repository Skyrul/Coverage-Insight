<?php

/**
 * @property string $refer_id
 * @property string $refer_email
 * @property string $refer_date
 * @property double $gc_amount
 * @property string $gc_offer
 * @property integer $account_id
 */
class SendCreditForm extends CFormModel
{

    public $refer_id;
    public $refer_email;
    public $refer_date;
    public $gc_amount;
    public $gc_offer;
    public $account_id;
    
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            // validation
			array('refer_id, refer_email, refer_date, gc_amount, gc_offer, account_id', 'required'),
            array('gc_amount, account_id', 'numerical', 'integerOnly'=>true),
            array('refer_email', 'email'),
			array('refer_id, refer_email, refer_date, gc_amount, gc_offer', 'safe'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'refer_id' => 'Referral Card',
			'refer_email' => 'Email',
		    'refer_date' => 'Date',
			'gc_amount' => 'Amount',
			'gc_offer' => 'Offer',
			'account_id' => 'Account ID',
		);
	}

	
}
