<?php

/**
 * This is the model class for table "tbl_payments".
 *
 * The followings are the available columns in table 'tbl_payments':
 * @property integer $id
 * @property integer $account_id
 * @property string $created_at
 * @property string $invoice_number
 * @property double $enrollment_fee
 * @property double $staff_fee
 * @property double $videoconf_fee
 * @property string $promo_code
 * @property double $promo_off
 * @property double $invoice_total
 * @property string $invoice_description
 * @property string $payment_date
 * @property string $invoice_type
 * @property string $creditcard
 * @property string $anet_customer_profile_id
 * @property string $anet_payment_profile_id
 * @property string $anet_transaction_id
 */
class Payments extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_payments';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('account_id, created_at, invoice_number, invoice_total, invoice_description, payment_date, invoice_type, creditcard, anet_customer_profile_id, anet_payment_profile_id, anet_transaction_id', 'required'),
			array('account_id', 'numerical', 'integerOnly'=>true),
			array('enrollment_fee, staff_fee, videoconf_fee, promo_off, invoice_total', 'numerical'),
			array('invoice_number, promo_code, creditcard, anet_customer_profile_id, anet_payment_profile_id', 'length', 'max'=>64),
			array('invoice_description', 'length', 'max'=>124),
			array('invoice_type', 'length', 'max'=>24),
			array('anet_transaction_id', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, account_id, created_at, invoice_number, enrollment_fee, staff_fee, promo_code, promo_off, invoice_total, invoice_description, payment_date, invoice_type, creditcard, anet_customer_profile_id, anet_payment_profile_id, anet_transaction_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'account_id' => 'Account',
			'created_at' => 'Created At',
			'invoice_number' => 'Invoice Number',
			'enrollment_fee' => 'Enrollment Fee',
			'staff_fee' => 'Staff Fee',
			'videoconf_fee' => 'Video Conference Fee',
			'promo_code' => 'Promo Code',
			'promo_off' => 'Promo Off',
			'invoice_total' => 'Invoice Total',
			'invoice_description' => 'Invoice Description',
			'payment_date' => 'Invoice Date',
			'invoice_type' => 'Invoice Type',
			'creditcard' => 'Creditcard',
			'anet_customer_profile_id' => 'Anet Customer Profile',
			'anet_payment_profile_id' => 'Anet Payment Profile',
			'anet_transaction_id' => 'Anet Transaction',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('account_id',$this->account_id);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('invoice_number',$this->invoice_number,true);
		$criteria->compare('enrollment_fee',$this->enrollment_fee);
		$criteria->compare('staff_fee',$this->staff_fee);
		$criteria->compare('videoconf_fee',$this->videoconf_fee);
		$criteria->compare('promo_code',$this->promo_code,true);
		$criteria->compare('promo_off',$this->promo_off);
		$criteria->compare('invoice_total',$this->invoice_total);
		$criteria->compare('invoice_description',$this->invoice_description,true);
		$criteria->compare('payment_date',$this->payment_date,true);
		$criteria->compare('invoice_type',$this->invoice_type,true);
		$criteria->compare('creditcard',$this->creditcard,true);
		$criteria->compare('anet_customer_profile_id',$this->anet_customer_profile_id,true);
		$criteria->compare('anet_payment_profile_id',$this->anet_payment_profile_id,true);
		$criteria->compare('anet_transaction_id',$this->anet_transaction_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Payments the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
