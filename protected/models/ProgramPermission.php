<?php

/**
 * This is the model class for table "tbl_program_permission".
 *
 * The followings are the available columns in table 'tbl_program_permission':
 * @property integer $id
 * @property string $program_code
 * @property integer $account_id
 * @property integer $security_group_id
 * @property string $enable
 * @property string $visible
 */
class ProgramPermission extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_program_permission';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('account_id, security_group_id', 'numerical', 'integerOnly'=>true),
			array('program_code', 'length', 'max'=>12),
			array('enable, visible', 'length', 'max'=>4),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, program_code, account_id, security_group_id, enable, visible', 'safe', 'on'=>'search'),
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
		    'feature'=>array(self::HAS_ONE, 'ProgramFeatures', 'program_code'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'program_code' => 'Program Code',
			'account_id' => 'Account',
			'security_group_id' => 'Security Group',
			'enable' => 'Enable',
			'visible' => 'Visible',
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
		$criteria->compare('program_code',$this->program_code,true);
		$criteria->compare('account_id',$this->account_id);
		$criteria->compare('security_group_id',$this->security_group_id);
		$criteria->compare('enable',$this->enable,true);
		$criteria->compare('visible',$this->visible,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ProgramPermission the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
