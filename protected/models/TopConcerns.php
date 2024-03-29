<?php

/**
 * This is the model class for table "tbl_top_concerns".
 *
 * The followings are the available columns in table 'tbl_top_concerns':
 * @property integer $id
 * @property integer $customer_id
 * @property string $assessment_guid
 * @property string $concern_question
 * @property string $concern_answer
 * @property integer $account_id
 * @property string $cir_answer
 */
class TopConcerns extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_top_concerns';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('customer_id, account_id', 'required'),
			array('customer_id, account_id', 'numerical', 'integerOnly'=>true),
			array('assessment_guid, cir_answer', 'length', 'max'=>255),
			array('concern_question, concern_answer', 'length', 'max'=>45),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, customer_id, assessment_guid, concern_question, concern_answer, account_id, cir_answer', 'safe', 'on'=>'search'),
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
			'customer_id' => 'Customer',
			'assessment_guid' => 'Assessment Guid',
			'concern_question' => 'Concern Question',
			'concern_answer' => 'Concern Answer',
			'account_id' => 'Account',
			'cir_answer' => 'Cir Answer',
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
		$criteria->compare('customer_id',$this->customer_id);
		$criteria->compare('assessment_guid',$this->assessment_guid,true);
		$criteria->compare('concern_question',$this->concern_question,true);
		$criteria->compare('concern_answer',$this->concern_answer,true);
		$criteria->compare('account_id',$this->account_id);
		$criteria->compare('cir_answer',$this->cir_answer,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TopConcerns the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
