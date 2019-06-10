<?php

/**
 * This is the model class for table "tbl_feedback".
 *
 * The followings are the available columns in table 'tbl_feedback':
 * @property integer $id
 * @property string $page_url
 * @property string $reporter_name
 * @property string $reporter_email
 * @property string $message
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 * @property integer $account_id
 */
class Feedback extends CActiveRecord
{
	public $image;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_feedback';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('page_url, reporter_name, reporter_email, message, account_id', 'required'),
			array('account_id', 'numerical', 'integerOnly'=>true),
			array('reporter_name, status', 'length', 'max'=>45),
			array('reporter_email', 'length', 'max'=>255),
			array('created_at, updated_at', 'safe'),
			array('image', 'file', 'types'=>'jpg, png', 'allowEmpty'=>true, 'safe'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, page_url, reporter_name, reporter_email, message, status, created_at, updated_at, account_id', 'safe', 'on'=>'search'),
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
			'page_url' => 'Url',
			'reporter_name' => 'Name',
			'reporter_email' => 'Email',
			'message' => 'Message',
			'status' => 'Status',
			'created_at' => 'Created',
			'updated_at' => 'Updated',
			'account_id' => 'Account',
			'image' => 'Attachment',
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
		$criteria->compare('page_url',$this->page_url,true);
		$criteria->compare('reporter_name',$this->reporter_name,true);
		$criteria->compare('reporter_email',$this->reporter_email,true);
		$criteria->compare('message',$this->message,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('updated_at',$this->updated_at,true);
		$criteria->compare('account_id',$this->account_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Feedback the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
