<?php

/**
 * This is the model class for table "tbl_needs_assessment".
 *
 * The followings are the available columns in table 'tbl_needs_assessment':
 * @property integer $id
 * @property string $assessment_guid
 * @property integer $customer_id
 * @property string $assessment_submitted_to
 * @property integer $is_steps_completed
 * @property integer $account_id
 */
class NeedsAssessment extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_needs_assessment';
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
			array('customer_id, is_steps_completed, account_id', 'numerical', 'integerOnly'=>true),
			array('assessment_guid, assessment_submitted_to', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, assessment_guid, customer_id, assessment_submitted_to, is_steps_completed, account_id', 'safe', 'on'=>'search'),
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
			'assessment_guid' => 'Assessment Guid',
			'customer_id' => 'Customer',
			'assessment_submitted_to' => 'Assessment Submitted To',
			'is_steps_completed' => 'Is Steps Completed',
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
		$criteria->compare('assessment_guid',$this->assessment_guid,true);
		$criteria->compare('customer_id',$this->customer_id);
		$criteria->compare('assessment_submitted_to',$this->assessment_submitted_to,true);
		$criteria->compare('is_steps_completed',$this->is_steps_completed);
		$criteria->compare('account_id',$this->account_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return NeedsAssessment the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
