<?php

/**
 * This is the model class for table "tbl_policies_in_place".
 *
 * The followings are the available columns in table 'tbl_policies_in_place':
 * @property integer $id
 * @property integer $customer_id
 * @property string $assessment_guid
 * @property string $policy_parent_label
 * @property string $policy_child_label
 * @property string $policy_child_selected
 * @property string $policy_child_selected_year
 * @property string $policy_child_selected_make
 * @property string $policy_child_selected_model
 * @property string $insurance_company
 * @property integer $account_id
 */
class PoliciesInPlace extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_policies_in_place';
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
			array('assessment_guid, insurance_company', 'length', 'max'=>255),
			array('policy_parent_label, policy_child_label', 'length', 'max'=>45),
			array('policy_child_selected, policy_child_selected_year, policy_child_selected_make, policy_child_selected_model', 'length', 'max'=>145),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, customer_id, assessment_guid, policy_parent_label, policy_child_label, policy_child_selected, policy_child_selected_year, policy_child_selected_make, policy_child_selected_model, insurance_company, account_id', 'safe', 'on'=>'search'),
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
			'policy_parent_label' => 'Policy Parent Label',
			'policy_child_label' => 'Policy Child Label',
			'policy_child_selected' => 'Policy Child Selected',
			'policy_child_selected_year' => 'Policy Child Selected Year',
			'policy_child_selected_make' => 'Policy Child Selected Make',
			'policy_child_selected_model' => 'Policy Child Selected Model',
			'insurance_company' => 'Insurance Company',
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
		$criteria->compare('customer_id',$this->customer_id);
		$criteria->compare('assessment_guid',$this->assessment_guid,true);
		$criteria->compare('policy_parent_label',$this->policy_parent_label,true);
		$criteria->compare('policy_child_label',$this->policy_child_label,true);
		$criteria->compare('policy_child_selected',$this->policy_child_selected,true);
		$criteria->compare('policy_child_selected_year',$this->policy_child_selected_year,true);
		$criteria->compare('policy_child_selected_make',$this->policy_child_selected_make,true);
		$criteria->compare('policy_child_selected_model',$this->policy_child_selected_model,true);
		$criteria->compare('insurance_company',$this->insurance_company,true);
		$criteria->compare('account_id',$this->account_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PoliciesInPlace the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
