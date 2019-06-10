<?php

/**
 * This is the model class for table "tbl_action_item".
 *
 * The followings are the available columns in table 'tbl_action_item':
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
class ActionItem extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_action_item';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
// 			array('customer_id, account_id, description, owner, created_date', 'required'),
		    array('account_id, description, owner, created_date', 'required'),
			array('customer_id, is_opportunity, is_completed, account_id', 'numerical', 'integerOnly'=>true),
			array('action_type_code, owner', 'length', 'max'=>45),
			array('ci_review_guid', 'length', 'max'=>255),
			array('description, created_date, due_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, customer_id, action_type_code, owner, description, ci_review_guid, is_opportunity, is_completed, created_date, due_date, account_id', 'safe', 'on'=>'search'),
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
			'customer'=>array(self::HAS_ONE, 'Customer', 'id')
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
	 * @return ActionItem the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function beforeSave()
	{
	    if(parent::beforeSave()){
	    	$this->created_date=date('Y-m-d', strtotime(str_replace(",", "", $this->created_date)));
	        $this->due_date=date('Y-m-d', strtotime(str_replace(",", "", $this->due_date)));
	        return TRUE;
	    }
	    else return false;
	}
}
