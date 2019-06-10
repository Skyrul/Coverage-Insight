<?php

/**
 * This is the model class for table "tbl_colour_custom".
 *
 * The followings are the available columns in table 'tbl_colour_custom':
 * @property integer $id
 * @property integer $account_id
 * @property string $color_1
 * @property string $color_2
 * @property string $color_3
 * @property string $color_4
 * @property string $color_5
 * @property string $color_6
 */
class ColourCustom extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_colour_custom';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('account_id, color_1, color_2, color_3, color_4, color_5, color_6', 'required'),
			array('account_id', 'numerical', 'integerOnly'=>true),
			array('color_1, color_2, color_3, color_4, color_5, color_6', 'length', 'max'=>45),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, account_id, color_1, color_2, color_3, color_4, color_5, color_6', 'safe', 'on'=>'search'),
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
			'account_id' => 'Account',
			'color_1' => 'Color 1',
			'color_2' => 'Color 2',
			'color_3' => 'Color 3',
			'color_4' => 'Color 4',
			'color_5' => 'Color 5',
			'color_6' => 'Color 6',
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
		$criteria->compare('account_id',$this->account_id);
		$criteria->compare('color_1',$this->color_1,true);
		$criteria->compare('color_2',$this->color_2,true);
		$criteria->compare('color_3',$this->color_3,true);
		$criteria->compare('color_4',$this->color_4,true);
		$criteria->compare('color_5',$this->color_5,true);
		$criteria->compare('color_6',$this->color_6,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ColourCustom the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
