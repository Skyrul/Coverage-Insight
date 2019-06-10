<?php

/**
 * This is the model class for table "tbl_videoconference".
 *
 * The followings are the available columns in table 'tbl_videoconference':
 * @property integer $id
 * @property integer $customer_id
 * @property integer $account_id
 * @property string $generated_url
 * @property string $verification_code
 * @property string $sched_date
 * @property string $sched_time
 * @property string $remarks
 * @property string $status
 * @property string $created_at
 */
class Videoconference extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_videoconference';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('customer_id, account_id, generated_url, verification_code, sched_date, sched_time, remarks, created_at', 'required'),
			array('customer_id, account_id', 'numerical', 'integerOnly'=>true),
			array('status', 'length', 'max'=>14),
			array('sched_time', 'length', 'max'=>16),
			array('sched_time', 'isValidTime'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, customer_id, account_id, generated_url, verification_code, sched_date, sched_time, remarks, created_at', 'safe', 'on'=>'search'),
		);
	}

	public function isValidTime($attribute)
	{
		if(!preg_match("/^(?:2[0-3]|[01][0-9]):[0-5][0-9]$/", $this->$attribute))
		  $this->addError($attribute, 'Invalid 24hour time format (HH:MM)');
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
			'account_id' => 'Account',
			'generated_url' => 'Generated Url',
			'verification_code' => 'Verification Code',
			'sched_date' => 'Schedule Date',
			'sched_time' => 'Schedule Time',
			'remarks' => 'Notes',
			'status' => 'Status',
			'created_at' => 'Created At',
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
		$criteria->compare('account_id',$this->account_id);
		$criteria->compare('generated_url',$this->generated_url,true);
		$criteria->compare('verification_code',$this->verification_code,true);
		$criteria->compare('sched_date',$this->sched_date,true);
		$criteria->compare('sched_time',$this->sched_time,true);
		$criteria->compare('remarks',$this->remarks,true);
		$criteria->compare('status',$this->remarks,true);
		$criteria->compare('created_at',$this->created_at,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Videoconference the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}