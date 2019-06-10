<?php

/**
 * This is the model class for table "tbl_credit_card_settings".
 *
 * The followings are the available columns in table 'tbl_credit_card_settings':
 * @property integer $id
 * @property string $created_at
 * @property integer $account_id
 * @property integer $is_primary
 * @property string $cim_customer_profile_id
 * @property string $cim_payment_profile_id
 * @property string $credit_card
 * @property string $card_type
 */
class CreditCardSettings extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_credit_card_settings';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('created_at, account_id, credit_card', 'required'),
			array('account_id, is_primary', 'numerical', 'integerOnly'=>true),
			array('cim_customer_profile_id, cim_payment_profile_id', 'length', 'max'=>124),
			array('credit_card, card_type', 'length', 'max'=>45),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, created_at, account_id, is_primary, cim_customer_profile_id, cim_payment_profile_id, credit_card, card_type', 'safe', 'on'=>'search'),
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
			'created_at' => 'Created At',
			'account_id' => 'Account',
			'is_primary' => 'Is Primary',
			'cim_customer_profile_id' => 'Cim Customer Profile',
			'cim_payment_profile_id' => 'Cim Payment Profile',
			'credit_card' => 'Credit Card',
			'card_type' => 'Card Type',
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
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('account_id',$this->account_id);
		$criteria->compare('is_primary',$this->is_primary);
		$criteria->compare('cim_customer_profile_id',$this->cim_customer_profile_id,true);
		$criteria->compare('cim_payment_profile_id',$this->cim_payment_profile_id,true);
		$criteria->compare('credit_card',$this->credit_card,true);
		$criteria->compare('card_type',$this->card_type,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CreditCardSettings the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
