<?php

/**
 * This is the model class for table "vw_action_item".
 *
 * The followings are the available columns in table 'vw_action_item':
 * @property string $primary_firstname
 * @property string $primary_lastname
 * @property string $primary_telno
 * @property string $primary_email
 * @property string $primary_emergency_contact
 * @property string $secondary_firstname
 * @property string $secondary_lastname
 * @property string $secondary_telno
 * @property string $secondary_email
 * @property string $secondary_emergency_contact
 * @property integer $id
 * @property integer $customer_id
 * @property string $action_type_code
 * @property string $owner
 * @property string $description
 * @property string $ci_review_guid
 * @property integer $is_opportunity
 * @property integer $is_completed
 * @property string $created_date
 * @property string $due_date
 * @property integer $account_id
 */
class ActionItemView extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'vw_action_item';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('customer_id, action_type_code, account_id', 'required'),
			array('id, customer_id, is_opportunity, is_completed, account_id', 'numerical', 'integerOnly'=>true),
			array('primary_firstname, primary_lastname, primary_emergency_contact, secondary_firstname, secondary_lastname, secondary_emergency_contact, action_type_code, owner', 'length', 'max'=>45),
			array('primary_telno, primary_email, secondary_telno, secondary_email', 'length', 'max'=>75),
			array('ci_review_guid', 'length', 'max'=>255),
			array('description, created_date, due_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('primary_firstname, primary_lastname, primary_telno, primary_email, primary_emergency_contact, secondary_firstname, secondary_lastname, secondary_telno, secondary_email, secondary_emergency_contact, id, customer_id, action_type_code, owner, description, ci_review_guid, is_opportunity, is_completed, created_date, due_date, account_id', 'safe', 'on'=>'search'),
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
			'primary_firstname' => 'Primary Firstname',
			'primary_lastname' => 'Primary Lastname',
			'primary_telno' => 'Primary Telno',
			'primary_email' => 'Primary Email',
			'primary_emergency_contact' => 'Primary Emergency Contact',
			'secondary_firstname' => 'Secondary Firstname',
			'secondary_lastname' => 'Secondary Lastname',
			'secondary_telno' => 'Secondary Telno',
			'secondary_email' => 'Secondary Email',
			'secondary_emergency_contact' => 'Secondary Emergency Contact',
			'id' => 'ID',
			'customer_id' => 'Customer',
			'action_type_code' => 'Action Type Code',
			'owner' => 'Owner',
			'description' => 'Description',
			'ci_review_guid' => 'Ci Review Guid',
			'is_opportunity' => 'Is Opportunity',
			'is_completed' => 'Is Completed',
			'created_date' => 'Created Date',
			'due_date' => 'Due Date',
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

		$criteria->compare('primary_firstname',$this->primary_firstname,true);
		$criteria->compare('primary_lastname',$this->primary_lastname,true);
		$criteria->compare('primary_telno',$this->primary_telno,true);
		$criteria->compare('primary_email',$this->primary_email,true);
		$criteria->compare('primary_emergency_contact',$this->primary_emergency_contact,true);
		$criteria->compare('secondary_firstname',$this->secondary_firstname,true);
		$criteria->compare('secondary_lastname',$this->secondary_lastname,true);
		$criteria->compare('secondary_telno',$this->secondary_telno,true);
		$criteria->compare('secondary_email',$this->secondary_email,true);
		$criteria->compare('secondary_emergency_contact',$this->secondary_emergency_contact,true);
		$criteria->compare('id',$this->id);
		$criteria->compare('customer_id',$this->customer_id);
		$criteria->compare('action_type_code',$this->action_type_code,true);
		$criteria->compare('owner',$this->owner,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('ci_review_guid',$this->ci_review_guid,true);
		$criteria->compare('is_opportunity',$this->is_opportunity);
		$criteria->compare('is_completed',$this->is_completed);
		$criteria->compare('created_date',$this->created_date,true);
		$criteria->compare('due_date',$this->due_date,true);
		$criteria->compare('account_id',$this->account_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ActionItemView the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
