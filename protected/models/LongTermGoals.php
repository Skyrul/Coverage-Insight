<?php

/**
 * This is the model class for table "tbl_long_term_goals".
 *
 * The followings are the available columns in table 'tbl_long_term_goals':
 * @property integer $id
 * @property integer $customer_id
 * @property string $assessment_guid
 * @property string $first_goal
 * @property string $second_goal
 * @property integer $account_id
 * @property string $cir_answer
 */
class LongTermGoals extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_long_term_goals';
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
			array('assessment_guid', 'length', 'max'=>255),
			array('cir_answer', 'length', 'max'=>45),
			array('first_goal, second_goal', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, customer_id, assessment_guid, first_goal, second_goal, account_id, cir_answer', 'safe', 'on'=>'search'),
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
			'first_goal' => 'First Goal',
			'second_goal' => 'Second Goal',
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
		$criteria->compare('first_goal',$this->first_goal,true);
		$criteria->compare('second_goal',$this->second_goal,true);
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
	 * @return LongTermGoals the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
