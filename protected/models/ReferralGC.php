<?php

/**
 * This is the model class for table "tbl_referral_gc".
 *
 * The followings are the available columns in table 'tbl_referral_gc':
 * @property integer $id
 * @property integer $refer_id
 * @property string $refer_email
 * @property string $refer_date
 * @property double $gc_amount
 * @property string $gc_offer
 * @property string $status
 * @property string $anet_transaction_id
 * @property string $order_json
 * @property integer $account_id
 */
class ReferralGC extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_referral_gc';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('refer_id, refer_email, refer_date, gc_amount, gc_offer, account_id', 'required'),
			array('refer_id, account_id', 'numerical', 'integerOnly'=>true),
			array('gc_amount', 'numerical'),
			array('refer_email', 'length', 'max'=>200),
			array('anet_transaction_id', 'length', 'max'=>300),
			array('refer_email', 'email'),
			array('gc_offer', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, refer_id, refer_email, refer_date, gc_amount, gc_offer, anet_transaction_id, account_id', 'safe', 'on'=>'search'),
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
			'refer_id' => 'Refer',
			'refer_email' => 'Refer Email',
			'refer_date' => 'Refer Date',
			'gc_amount' => 'Gc Amount',
			'gc_offer' => 'Gc Offer',
			'anet_transaction_id' => 'Payment Transaction Id',
			'order_json'=>'Order JSON',
			'account_id' => 'Account',
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
		$criteria->compare('refer_id',$this->refer_id);
		$criteria->compare('refer_email',$this->refer_email,true);
		$criteria->compare('refer_date',$this->refer_date,true);
		$criteria->compare('gc_amount',$this->gc_amount);
		$criteria->compare('gc_offer',$this->gc_offer,true);
		$criteria->compare('account_id',$this->account_id);
		$criteria->compare('anet_transaction_id',$this->anet_transaction_id);
		

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ReferralGC the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
