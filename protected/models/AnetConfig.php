<?php

/**
 * This is the model class for table "tbl_anet_config".
 *
 * The followings are the available columns in table 'tbl_anet_config':
 * @property integer $id
 * @property string $api_login_id
 * @property string $transaction_key
 * @property string $api_login_id2
 * @property string $transaction_key2
 * @property integer $is_sandbox
 */
class AnetConfig extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_anet_config';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('api_login_id, transaction_key, api_login_id2, transaction_key2, is_sandbox', 'required'),
			array('is_sandbox', 'numerical', 'integerOnly'=>true),
			array('api_login_id, transaction_key, api_login_id2, transaction_key2', 'length', 'max'=>55),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, api_login_id, transaction_key, api_login_id2, transaction_key2, is_sandbox', 'safe', 'on'=>'search'),
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
			'api_login_id' => 'Api Login ID',
			'transaction_key' => 'Transaction Key',
			'api_login_id2' => 'Api Login ID',
			'transaction_key2' => 'Transaction Key',
			'is_sandbox' => 'Select Environment',
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
		$criteria->compare('api_login_id',$this->api_login_id,true);
		$criteria->compare('transaction_key',$this->transaction_key,true);
		$criteria->compare('api_login_id2',$this->api_login_id2,true);
		$criteria->compare('transaction_key2',$this->transaction_key2,true);
		$criteria->compare('is_sandbox',$this->is_sandbox);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AnetConfig the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
