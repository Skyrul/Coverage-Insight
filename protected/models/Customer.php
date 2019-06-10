<?php

/**
 * This is the model class for table "tbl_customer".
 *
 * The followings are the available columns in table 'tbl_customer':
 * @property integer $id
 * @property string $primary_firstname
 * @property string $primary_lastname
 * @property string $primary_telno
 * @property string $primary_cellphone
 * @property string $primary_alt_telno
 * @property string $primary_address
 * @property string $primary_email
 * @property string $primary_emergency_contact
 * @property string $secondary_firstname
 * @property string $secondary_lastname
 * @property string $secondary_telno
 * @property string $secondary_cellphone
 * @property string $secondary_alt_telno
 * @property string $secondary_address
 * @property string $secondary_email
 * @property string $secondary_emergency_contact
 * @property string $created_at
 * @property string $updated_at
 * @property integer $account_id
 */
class Customer extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_customer';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('primary_firstname, primary_lastname, account_id', 'required'),
			array('account_id', 'numerical', 'integerOnly'=>true),
			array('primary_firstname, primary_lastname, primary_emergency_contact, secondary_firstname, secondary_lastname, secondary_emergency_contact', 'length', 'max'=>45),
			array('primary_telno, primary_cellphone, primary_alt_telno, primary_email, secondary_telno, secondary_cellphone, secondary_alt_telno, secondary_email', 'length', 'max'=>75),
			array('primary_address, secondary_address', 'length', 'max'=>255),
			array('updated_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, primary_firstname, primary_lastname, primary_telno, primary_cellphone, primary_alt_telno, primary_address, primary_email, primary_emergency_contact, secondary_firstname, secondary_lastname, secondary_telno, secondary_cellphone, secondary_alt_telno, secondary_address, secondary_email, secondary_emergency_contact, created_at, updated_at, account_id', 'safe', 'on'=>'search'),
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
			'primary_firstname' => 'Primary Firstname',
			'primary_lastname' => 'Primary Lastname',
			'primary_telno' => 'Primary Telno',
			'primary_cellphone' => 'Primary Cellphone',
			'primary_alt_telno' => 'Primary Alt Telno',
			'primary_address' => 'Primary Address',
			'primary_email' => 'Primary Email',
			'primary_emergency_contact' => 'Primary Emergency Contact',
			'secondary_firstname' => 'Secondary Firstname',
			'secondary_lastname' => 'Secondary Lastname',
			'secondary_telno' => 'Secondary Telno',
			'secondary_cellphone' => 'Secondary Cellphone',
			'secondary_alt_telno' => 'Secondary Alt Telno',
			'secondary_address' => 'Secondary Address',
			'secondary_email' => 'Secondary Email',
			'secondary_emergency_contact' => 'Secondary Emergency Contact',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
			'account_id' => 'Account',
		);
	}

	public function beforeSave() {
	    if ($this->isNewRecord)
	        $this->created_at = new CDbExpression('NOW()');
	    else
	        $this->updated_at = new CDbExpression('NOW()');

	    return parent::beforeSave();
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
		$criteria->compare('primary_firstname',$this->primary_firstname,true);
		$criteria->compare('primary_lastname',$this->primary_lastname,true);
		$criteria->compare('primary_telno',$this->primary_telno,true);
		$criteria->compare('primary_cellphone',$this->primary_cellphone,true);
		$criteria->compare('primary_alt_telno',$this->primary_alt_telno,true);
		$criteria->compare('primary_address',$this->primary_address,true);
		$criteria->compare('primary_email',$this->primary_email,true);
		$criteria->compare('primary_emergency_contact',$this->primary_emergency_contact,true);
		$criteria->compare('secondary_firstname',$this->secondary_firstname,true);
		$criteria->compare('secondary_lastname',$this->secondary_lastname,true);
		$criteria->compare('secondary_telno',$this->secondary_telno,true);
		$criteria->compare('secondary_cellphone',$this->secondary_cellphone,true);
		$criteria->compare('secondary_alt_telno',$this->secondary_alt_telno,true);
		$criteria->compare('secondary_address',$this->secondary_address,true);
		$criteria->compare('secondary_email',$this->secondary_email,true);
		$criteria->compare('secondary_emergency_contact',$this->secondary_emergency_contact,true);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('updated_at',$this->updated_at,true);
		$criteria->compare('account_id',$this->account_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static function filtered_customer()
	{
		$criteria = new CDbCriteria();
		$criteria->condition = 'account_id=:account_id';
		$criteria->params = array(':account_id'=>Yii::app()->session['account_id']);
		$model = Customer::model()->findAll($criteria);
		$list = CHtml::dropDownList("ActionItem[customer_id]",
									"ActionItem[customer_id]",
									CHtml::listData($model, "id",
									function($data) {
        									return $data->primary_firstname . " " . $data->primary_lastname;
    								}));
		return preg_replace( "/\r|\n/", "", $list);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Customer the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
