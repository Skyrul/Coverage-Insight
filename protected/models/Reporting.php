<?php

/**
 * This is the model class for table "tbl_reporting".
 *
 * The followings are the available columns in table 'tbl_reporting':
 * @property integer $id
 * @property string $report_name
 * @property string $data1
 * @property string $data2
 * @property string $data3
 * @property string $data4
 */
class Reporting extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_reporting';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('report_name', 'length', 'max'=>45),
			array('data1, data2, data3, data4', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, report_name, data1, data2, data3, data4', 'safe', 'on'=>'search'),
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
			'report_name' => 'Report Name',
			'data1' => 'Data1',
			'data2' => 'Data2',
			'data3' => 'Data3',
			'data4' => 'Data4',
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
		$criteria->compare('report_name',$this->report_name,true);
		$criteria->compare('data1',$this->data1,true);
		$criteria->compare('data2',$this->data2,true);
		$criteria->compare('data3',$this->data3,true);
		$criteria->compare('data4',$this->data4,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Reporting the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
