<?php

/**
 * This is the model class for table "tbl_vi_config".
 *
 * The followings are the available columns in table 'tbl_vi_config':
 * @property integer $id
 * @property string $username1
 * @property string $password1
 * @property string $username2
 * @property string $password2
 * @property integer $is_sandbox
 * @property string $program_id
 * @property string $sku
 * @property double $max_amount
 */
class ViConfig extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_vi_config';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username1, password1, username2, password2, is_sandbox', 'required'),
			array('is_sandbox', 'numerical', 'integerOnly'=>true),
			array('max_amount', 'numerical'),
			array('username1, password1, username2, password2', 'length', 'max'=>55),
			array('program_id', 'length', 'max'=>45),
			array('sku', 'length', 'max'=>65),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, username1, password1, username2, password2, is_sandbox, program_id, sku, max_amount', 'safe', 'on'=>'search'),
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
			'username1' => 'Username1',
			'password1' => 'Password1',
			'username2' => 'Username2',
			'password2' => 'Password2',
			'is_sandbox' => 'Is Sandbox',
			'program_id' => 'Program',
			'sku' => 'Sku',
			'max_amount' => 'Max Amount',
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
		$criteria->compare('username1',$this->username1,true);
		$criteria->compare('password1',$this->password1,true);
		$criteria->compare('username2',$this->username2,true);
		$criteria->compare('password2',$this->password2,true);
		$criteria->compare('is_sandbox',$this->is_sandbox);
		$criteria->compare('program_id',$this->program_id,true);
		$criteria->compare('sku',$this->sku,true);
		$criteria->compare('max_amount',$this->max_amount);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ViConfig the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
