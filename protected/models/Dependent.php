<?php

/**
 * This is the model class for table "tbl_dependent".
 *
 * The followings are the available columns in table 'tbl_dependent':
 * @property integer $id
 * @property integer $customer_id
 * @property string $dependent_name
 * @property string $dependent_age
 * @property integer $account_id
 */
class Dependent extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_dependent';
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
			array('dependent_name, dependent_age', 'length', 'max'=>45),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, customer_id, dependent_name, dependent_age, account_id', 'safe', 'on'=>'search'),
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
			'dependent_name' => 'Dependent Name',
			'dependent_age' => 'Dependent Age',
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
		$criteria->compare('dependent_name',$this->dependent_name,true);
		$criteria->compare('dependent_age',$this->dependent_age,true);
		$criteria->compare('account_id',$this->account_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static function listAges()
	{
		$age_option = [];
		for ($i=0; $i <= 50 ; $i++) {
			$age_option[$i] = $i;
		}
		return $age_option;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Dependent the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
