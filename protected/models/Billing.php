<?php

/**
 * This is the model class for table "tbl_billing".
 *
 * The followings are the available columns in table 'tbl_billing':
 * @property integer $id
 * @property integer $account_id
 * @property string $bill_type
 * @property string $bill_no
 * @property double $fee
 * @property string $promo_code
 * @property double $promo_off
 * @property double $bill_amount
 * @property string $bill_status
 * @property string $created_at
 * @property string $due_date
 * @property string $next_billing
 */
class Billing extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_billing';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('account_id', 'numerical', 'integerOnly'=>true),
			array('fee, promo_off, bill_amount', 'numerical'),
			array('bill_type, bill_no, bill_status', 'length', 'max'=>45),
			array('promo_code', 'length', 'max'=>25),
			array('created_at, due_date, next_billing', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, account_id, bill_type, bill_no, fee, promo_code, promo_off, bill_amount, bill_status, created_at, due_date, next_billing', 'safe', 'on'=>'search'),
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
			'bill_type' => 'Invoice Type',
			'bill_no' => 'Invoice Number',
			'fee' => 'Fee',
			'promo_code' => 'Promo Code',
			'promo_off' => 'Promo Off',
			'bill_amount' => 'Invoice Amount',
			'bill_status' => 'Invoice Status',
			'created_at' => 'Invoice Date',
		    'due_date' => 'Due Date',
			'next_billing' => 'Next Billing',
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
		$criteria->compare('bill_type',$this->bill_type,true);
		$criteria->compare('bill_no',$this->bill_no,true);
		$criteria->compare('fee',$this->fee);
		$criteria->compare('promo_code',$this->promo_code,true);
		$criteria->compare('promo_off',$this->promo_off);
		$criteria->compare('bill_amount',$this->bill_amount);
		$criteria->compare('bill_status',$this->bill_status,true);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('next_billing',$this->next_billing,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Billing the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
