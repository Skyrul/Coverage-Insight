<?php

/**
 * This is the model class for table "tbl_gift_cards".
 *
 * The followings are the available columns in table 'tbl_gift_cards':
 * @property integer $id
 * @property integer $use_referral
 * @property integer $i_agree
 * @property integer $offer_pre_enrollment_credit
 * @property string $pre_credit_amounts
 * @property string $pre_gift_cards_offer
 * @property integer $offer_enrollment_credit
 * @property string $credit_amounts
 * @property string $gift_cards_offer
 * @property integer $account_id
 */
class GiftCards extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_gift_cards';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			// array('use_referral, i_agree, offer_pre_enrollment_credit, offer_enrollment_credit, account_id', 'numerical', 'integerOnly'=>true),
			array('use_referral, i_agree, offer_enrollment_credit, account_id', 'numerical', 'integerOnly'=>true),
			// array('pre_credit_amounts, credit_amounts', 'length', 'max'=>100),
			array('credit_amounts', 'length', 'max'=>100),
			// array('pre_gift_cards_offer, gift_cards_offer', 'length', 'max'=>200),
			array('gift_cards_offer', 'length', 'max'=>200),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			// array('id, use_referral, i_agree, offer_pre_enrollment_credit, pre_credit_amounts, pre_gift_cards_offer, offer_enrollment_credit, credit_amounts, gift_cards_offer, account_id', 'safe', 'on'=>'search'),
			array('id, use_referral, i_agree, offer_enrollment_credit, credit_amounts, gift_cards_offer, account_id', 'safe', 'on'=>'search'),
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
			'use_referral' => 'Use Referral',
			'i_agree' => 'I Agree',
			'offer_pre_enrollment_credit' => 'Offer Pre Enrollment Credit',
			'pre_credit_amounts' => 'Pre Credit Amounts',
			'pre_gift_cards_offer' => 'Pre Gift Cards Offer',
			'offer_enrollment_credit' => 'Offer Enrollment Credit',
			'credit_amounts' => 'Credit Amounts',
			'gift_cards_offer' => 'Gift Cards Offer',
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
		$criteria->compare('use_referral',$this->use_referral);
		$criteria->compare('i_agree',$this->i_agree);
		$criteria->compare('offer_pre_enrollment_credit',$this->offer_pre_enrollment_credit);
		$criteria->compare('pre_credit_amounts',$this->pre_credit_amounts,true);
		$criteria->compare('pre_gift_cards_offer',$this->pre_gift_cards_offer,true);
		$criteria->compare('offer_enrollment_credit',$this->offer_enrollment_credit);
		$criteria->compare('credit_amounts',$this->credit_amounts,true);
		$criteria->compare('gift_cards_offer',$this->gift_cards_offer,true);
		$criteria->compare('account_id',$this->account_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return GiftCards the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
