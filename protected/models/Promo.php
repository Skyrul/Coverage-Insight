<?php

/**
 * This is the model class for table "tbl_promo".
 *
 * The followings are the available columns in table 'tbl_promo':
 * @property integer $id
 * @property string $promo_name
 * @property string $promo_code
 * @property double $amount_off
 * @property double $valid_num_months
 * @property string $status
 * @property string $promo_start
 * @property string $promo_end
 * @property string $created_at
 */
class Promo extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_promo';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('promo_name, promo_code, amount_off, valid_num_months, status', 'required'),
			array('amount_off, valid_num_months', 'numerical'),
			array('promo_name', 'length', 'max'=>44),
			array('promo_code', 'length', 'max'=>5),
			array('status', 'length', 'max'=>12),
			array('promo_start, promo_end, created_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, promo_name, promo_code, amount_off, valid_num_months, status, promo_start, promo_end, created_at', 'safe', 'on'=>'search'),
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
			'promo_name' => 'Promo Name',
			'promo_code' => 'Promo Code',
			'amount_off' => 'Amount Off',
			'valid_num_months' => 'Valid Num Months',
			'status' => 'Status',
			'promo_start' => 'Promo Start',
			'promo_end' => 'Promo End',
			'created_at' => 'Created At',
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
		$criteria->compare('promo_name',$this->promo_name,true);
		$criteria->compare('promo_code',$this->promo_code,true);
		$criteria->compare('amount_off',$this->amount_off);
		$criteria->compare('valid_num_months',$this->valid_num_months);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('promo_start',$this->promo_start,true);
		$criteria->compare('promo_end',$this->promo_end,true);
		$criteria->compare('created_at',$this->created_at,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Promo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
