<?php

/**
 * This is the model class for table "tbl_referral".
 *
 * The followings are the available columns in table 'tbl_referral':
 * @property integer $id
 * @property string $refer_name
 * @property string $refer_email
 * @property string $refer_phone
 * @property string $refer_note
 * @property integer $account_id
 * @property integer $customer_id
 */
class Referral extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_referral';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
                        array('account_id, customer_id, refer_name, refer_email', 'required'),
			array('account_id, customer_id', 'numerical', 'integerOnly'=>true),
			array('refer_name, refer_email, refer_phone', 'length', 'max'=>145),
			array('refer_note', 'length', 'max'=>245),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, refer_name, refer_email, refer_phone, refer_note, account_id, customer_id', 'safe', 'on'=>'search'),
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
			'refer_name' => 'Refer Name',
			'refer_email' => 'Refer Email',
			'refer_phone' => 'Refer Phone',
			'refer_note' => 'Refer Note',
			'account_id' => 'Account',
			'customer_id' => 'Customer',
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
		$criteria->compare('refer_name',$this->refer_name,true);
		$criteria->compare('refer_email',$this->refer_email,true);
		$criteria->compare('refer_phone',$this->refer_phone,true);
		$criteria->compare('refer_note',$this->refer_note,true);
		$criteria->compare('account_id',$this->account_id);
		$criteria->compare('customer_id',$this->customer_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Referral the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
