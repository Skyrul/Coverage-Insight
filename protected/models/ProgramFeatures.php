<?php

/**
 * This is the model class for table "tbl_program_features".
 *
 * The followings are the available columns in table 'tbl_program_features':
 * @property integer $id
 * @property string $program_code
 * @property string $description
 * @property string $feature_type
 * @property string $page_identifier
 * @property string $feature_identifier
 * @property string $parent_id
 */
class ProgramFeatures extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_program_features';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('program_code, description', 'required'),
			array('program_code, parent_id', 'length', 'max'=>12),
			array('description, page_identifier, feature_identifier', 'length', 'max'=>300),
			array('feature_type', 'length', 'max'=>16),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, program_code, description, feature_type, page_identifier, feature_identifier, parent_id', 'safe', 'on'=>'search'),
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
			'program_code' => 'Program Code',
			'description' => 'Description',
			'feature_type' => 'Feature Type',
			'page_identifier' => 'Page Identifier',
			'feature_identifier' => 'Feature Identifier',
			'parent_id' => 'Parent',
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
		$criteria->compare('description',$this->description,true);
		$criteria->compare('feature_type',$this->feature_type,true);
		$criteria->compare('page_identifier',$this->page_identifier,true);
		$criteria->compare('feature_identifier',$this->feature_identifier,true);
		$criteria->compare('parent_id',$this->parent_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ProgramFeatures the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
