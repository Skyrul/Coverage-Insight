<?php

/**
 * This is the model class for table "tbl_goals_concern".
 *
 * The followings are the available columns in table 'tbl_goals_concern':
 * @property integer $id
 * @property integer $customer_id
 * @property string $ci_review_guid
 * @property string $action_type
 * @property string $action_description
 * @property integer $account_id
 * @property string $cir_answer
 */
class GoalsConcern extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_goals_concern';
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
			array('ci_review_guid, action_description', 'length', 'max'=>255),
			array('action_type, cir_answer', 'length', 'max'=>45),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, customer_id, ci_review_guid, action_type, action_description, account_id, cir_answer', 'safe', 'on'=>'search'),
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
			'ci_review_guid' => 'Ci Review Guid',
			'action_type' => 'Action Type',
			'action_description' => 'Action Description',
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
		$criteria->compare('ci_review_guid',$this->ci_review_guid,true);
		$criteria->compare('action_type',$this->action_type,true);
		$criteria->compare('action_description',$this->action_description,true);
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
	 * @return GoalsConcern the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
