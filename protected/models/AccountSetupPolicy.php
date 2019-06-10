<?php

/**
 * This is the model class for table "tbl_account_setup_policy".
 *
 * The followings are the available columns in table 'tbl_account_setup_policy':
 * @property integer $id
 * @property string $policy_parent_label
 * @property string $policy_child_label
 * @property string $policy_child_questions
 * @property string $policy_child_values
 * @property integer $is_child_checked
 * @property integer $account_id
 */
class AccountSetupPolicy extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_account_setup_policy';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('account_id', 'required'),
			array('is_child_checked, account_id', 'numerical', 'integerOnly'=>true),
			array('policy_parent_label', 'length', 'max'=>4),
			array('policy_child_label', 'length', 'max'=>45),
			array('policy_child_questions, policy_child_values', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, policy_parent_label, policy_child_label, policy_child_questions, policy_child_values, is_child_checked, account_id', 'safe', 'on'=>'search'),
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
			'policy_parent_label' => 'Policy Parent Label',
			'policy_child_label' => 'Policy Child Label',
			'policy_child_questions' => 'Policy Child Questions',
			'policy_child_values' => 'Policy Child Values',
			'is_child_checked' => 'Is Child Checked',
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
		$criteria->compare('policy_parent_label',$this->policy_parent_label,true);
		$criteria->compare('policy_child_label',$this->policy_child_label,true);
		$criteria->compare('policy_child_questions',$this->policy_child_questions,true);
		$criteria->compare('policy_child_values',$this->policy_child_values,true);
		$criteria->compare('is_child_checked',$this->is_child_checked);
		$criteria->compare('account_id',$this->account_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AccountSetupPolicy the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
