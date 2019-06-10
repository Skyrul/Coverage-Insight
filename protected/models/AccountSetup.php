<?php

/**
 * This is the model class for table "tbl_account_setup".
 *
 * The followings are the available columns in table 'tbl_account_setup':
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $agency_name
 * @property string $logo
 * @property string $timezone
 * @property string $password
 * @property string $created_at
 * @property string $updated_at
 * @property string $smtp_server
 * @property string $smtp_username
 * @property string $smtp_password
 * @property string $smtp_port
 * @property string $office_phone_number
 * @property string $apointment_locations
 * @property string $staff
 * @property integer $colour_scheme_id
 * @property integer $is_activated
 * @property integer $is_Auto_checked
 * @property integer $is_Home_checked
 * @property integer $is_Life_checked
 * @property integer $is_Personal_Liability_checked
 * @property integer $is_Disability_checked
 * @property integer $is_Health_checked
 * @property integer $is_Other_checked
 * @property integer $is_Commercial_checked
 */
class AccountSetup extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_account_setup';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('email, agency_name, password', 'required'),
			array('colour_scheme_id, is_activated, is_Auto_checked, is_Home_checked, is_Life_checked, is_Personal_Liability_checked, is_Disability_checked, is_Health_checked, is_Other_checked, is_Commercial_checked', 'numerical', 'integerOnly'=>true),
			array('first_name, last_name, smtp_username', 'length', 'max'=>45),
			array('email, agency_name', 'length', 'max'=>75),
			array('timezone', 'length', 'max'=>145),
			array('password, smtp_server, smtp_password', 'length', 'max'=>255),
			array('smtp_port', 'length', 'max'=>12),
			array('office_phone_number', 'length', 'max'=>254),
			array('logo, updated_at, apointment_locations, staff', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, first_name, last_name, email, agency_name, logo, timezone, created_at, updated_at, smtp_server, smtp_username, smtp_password, smtp_port, office_phone_number, apointment_locations, staff, colour_scheme_id, is_activated, is_Auto_checked, is_Home_checked, is_Life_checked, is_Personal_Liability_checked, is_Disability_checked, is_Health_checked, is_Other_checked, is_Commercial_checked', 'safe', 'on'=>'search'),
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
			'first_name' => 'First Name',
			'last_name' => 'Last Name',
			'email' => 'Email',
			'agency_name' => 'Agency Name',
			'logo' => 'Logo',
			'timezone' => 'Timezone',
			'password' => 'Password',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
			'smtp_server' => 'Smtp Server',
			'smtp_username' => 'Smtp Username',
			'smtp_password' => 'Smtp Password',
			'smtp_port' => 'Smtp Port',
			'office_phone_number' => 'Office Phone Number',
			'apointment_locations' => 'Apointment Locations',
			'staff' => 'Staff',
			'colour_scheme_id' => 'Colour Scheme',
			'is_activated' => 'Is Activated',
			'is_Auto_checked' => 'Is Auto Checked',
			'is_Home_checked' => 'Is Home Checked',
			'is_Life_checked' => 'Is Life Checked',
			'is_Personal_Liability_checked' => 'Is Personal Liability Checked',
			'is_Disability_checked' => 'Is Disability Checked',
			'is_Health_checked' => 'Is Health Checked',
			'is_Other_checked' => 'Is Other Checked',
			'is_Commercial_checked' => 'Is Commercial Checked',
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
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('agency_name',$this->agency_name,true);
		$criteria->compare('logo',$this->logo,true);
		$criteria->compare('timezone',$this->timezone,true);
		//$criteria->compare('password',$this->password,true);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('updated_at',$this->updated_at,true);
		$criteria->compare('smtp_server',$this->smtp_server,true);
		$criteria->compare('smtp_username',$this->smtp_username,true);
		$criteria->compare('smtp_password',$this->smtp_password,true);
		$criteria->compare('smtp_port',$this->smtp_port,true);
		$criteria->compare('office_phone_number',$this->office_phone_number,true);
		$criteria->compare('apointment_locations',$this->apointment_locations,true);
		$criteria->compare('staff',$this->staff,true);
		$criteria->compare('colour_scheme_id',$this->colour_scheme_id);
		$criteria->compare('is_activated',$this->is_activated);
		$criteria->compare('is_Auto_checked',$this->is_Auto_checked);
		$criteria->compare('is_Home_checked',$this->is_Home_checked);
		$criteria->compare('is_Life_checked',$this->is_Life_checked);
		$criteria->compare('is_Personal_Liability_checked',$this->is_Personal_Liability_checked);
		$criteria->compare('is_Disability_checked',$this->is_Disability_checked);
		$criteria->compare('is_Health_checked',$this->is_Health_checked);
		$criteria->compare('is_Other_checked',$this->is_Other_checked);
		$criteria->compare('is_Commercial_checked',$this->is_Commercial_checked);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AccountSetup the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
