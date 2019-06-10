<?php

/**
 * This is the model class for table "tbl_02_models".
 *
 * The followings are the available columns in table 'tbl_02_models':
 * @property integer $model_id
 * @property string $model_make_id
 * @property string $model_name
 * @property string $model_trim
 * @property integer $model_year
 * @property string $model_body
 * @property string $model_engine_position
 * @property integer $model_engine_cc
 * @property integer $model_engine_cyl
 * @property string $model_engine_type
 * @property integer $model_engine_valves_per_cyl
 * @property integer $model_engine_power_ps
 * @property integer $model_engine_power_rpm
 * @property integer $model_engine_torque_nm
 * @property integer $model_engine_torque_rpm
 * @property string $model_engine_bore_mm
 * @property string $model_engine_stroke_mm
 * @property string $model_engine_compression
 * @property string $model_engine_fuel
 * @property integer $model_top_speed_kph
 * @property string $model_0_to_100_kph
 * @property string $model_drive
 * @property string $model_transmission_type
 * @property integer $model_seats
 * @property integer $model_doors
 * @property integer $model_weight_kg
 * @property integer $model_length_mm
 * @property integer $model_width_mm
 * @property integer $model_height_mm
 * @property integer $model_wheelbase_mm
 * @property string $model_lkm_hwy
 * @property string $model_lkm_mixed
 * @property string $model_lkm_city
 * @property integer $model_fuel_cap_l
 * @property integer $model_sold_in_us
 * @property integer $model_co2
 * @property string $model_make_display
 */
class CarQuery extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_02_models';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('model_make_id, model_name, model_trim, model_year', 'required'),
			array('model_year, model_engine_cc, model_engine_cyl, model_engine_valves_per_cyl, model_engine_power_ps, model_engine_power_rpm, model_engine_torque_nm, model_engine_torque_rpm, model_top_speed_kph, model_seats, model_doors, model_weight_kg, model_length_mm, model_width_mm, model_height_mm, model_wheelbase_mm, model_fuel_cap_l, model_sold_in_us, model_co2', 'numerical', 'integerOnly'=>true),
			array('model_make_id, model_engine_type, model_engine_fuel, model_transmission_type, model_make_display', 'length', 'max'=>32),
			array('model_name, model_trim, model_body', 'length', 'max'=>64),
			array('model_engine_position, model_engine_compression', 'length', 'max'=>8),
			array('model_engine_bore_mm, model_engine_stroke_mm', 'length', 'max'=>6),
			array('model_0_to_100_kph, model_lkm_hwy, model_lkm_mixed, model_lkm_city', 'length', 'max'=>4),
			array('model_drive', 'length', 'max'=>16),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('model_id, model_make_id, model_name, model_trim, model_year, model_body, model_engine_position, model_engine_cc, model_engine_cyl, model_engine_type, model_engine_valves_per_cyl, model_engine_power_ps, model_engine_power_rpm, model_engine_torque_nm, model_engine_torque_rpm, model_engine_bore_mm, model_engine_stroke_mm, model_engine_compression, model_engine_fuel, model_top_speed_kph, model_0_to_100_kph, model_drive, model_transmission_type, model_seats, model_doors, model_weight_kg, model_length_mm, model_width_mm, model_height_mm, model_wheelbase_mm, model_lkm_hwy, model_lkm_mixed, model_lkm_city, model_fuel_cap_l, model_sold_in_us, model_co2, model_make_display', 'safe', 'on'=>'search'),
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
			'model_id' => 'Model',
			'model_make_id' => 'Model Make',
			'model_name' => 'Model Name',
			'model_trim' => 'Model Trim',
			'model_year' => 'Model Year',
			'model_body' => 'Model Body',
			'model_engine_position' => 'Model Engine Position',
			'model_engine_cc' => 'Model Engine Cc',
			'model_engine_cyl' => 'Model Engine Cyl',
			'model_engine_type' => 'Model Engine Type',
			'model_engine_valves_per_cyl' => 'Model Engine Valves Per Cyl',
			'model_engine_power_ps' => 'Model Engine Power Ps',
			'model_engine_power_rpm' => 'Model Engine Power Rpm',
			'model_engine_torque_nm' => 'Model Engine Torque Nm',
			'model_engine_torque_rpm' => 'Model Engine Torque Rpm',
			'model_engine_bore_mm' => 'Model Engine Bore Mm',
			'model_engine_stroke_mm' => 'Model Engine Stroke Mm',
			'model_engine_compression' => 'Model Engine Compression',
			'model_engine_fuel' => 'Model Engine Fuel',
			'model_top_speed_kph' => 'Model Top Speed Kph',
			'model_0_to_100_kph' => 'Model 0 To 100 Kph',
			'model_drive' => 'Model Drive',
			'model_transmission_type' => 'Model Transmission Type',
			'model_seats' => 'Model Seats',
			'model_doors' => 'Model Doors',
			'model_weight_kg' => 'Model Weight Kg',
			'model_length_mm' => 'Model Length Mm',
			'model_width_mm' => 'Model Width Mm',
			'model_height_mm' => 'Model Height Mm',
			'model_wheelbase_mm' => 'Model Wheelbase Mm',
			'model_lkm_hwy' => 'Model Lkm Hwy',
			'model_lkm_mixed' => 'Model Lkm Mixed',
			'model_lkm_city' => 'Model Lkm City',
			'model_fuel_cap_l' => 'Model Fuel Cap L',
			'model_sold_in_us' => 'Model Sold In Us',
			'model_co2' => 'Model Co2',
			'model_make_display' => 'Model Make Display',
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

		$criteria->compare('model_id',$this->model_id);
		$criteria->compare('model_make_id',$this->model_make_id,true);
		$criteria->compare('model_name',$this->model_name,true);
		$criteria->compare('model_trim',$this->model_trim,true);
		$criteria->compare('model_year',$this->model_year);
		$criteria->compare('model_body',$this->model_body,true);
		$criteria->compare('model_engine_position',$this->model_engine_position,true);
		$criteria->compare('model_engine_cc',$this->model_engine_cc);
		$criteria->compare('model_engine_cyl',$this->model_engine_cyl);
		$criteria->compare('model_engine_type',$this->model_engine_type,true);
		$criteria->compare('model_engine_valves_per_cyl',$this->model_engine_valves_per_cyl);
		$criteria->compare('model_engine_power_ps',$this->model_engine_power_ps);
		$criteria->compare('model_engine_power_rpm',$this->model_engine_power_rpm);
		$criteria->compare('model_engine_torque_nm',$this->model_engine_torque_nm);
		$criteria->compare('model_engine_torque_rpm',$this->model_engine_torque_rpm);
		$criteria->compare('model_engine_bore_mm',$this->model_engine_bore_mm,true);
		$criteria->compare('model_engine_stroke_mm',$this->model_engine_stroke_mm,true);
		$criteria->compare('model_engine_compression',$this->model_engine_compression,true);
		$criteria->compare('model_engine_fuel',$this->model_engine_fuel,true);
		$criteria->compare('model_top_speed_kph',$this->model_top_speed_kph);
		$criteria->compare('model_0_to_100_kph',$this->model_0_to_100_kph,true);
		$criteria->compare('model_drive',$this->model_drive,true);
		$criteria->compare('model_transmission_type',$this->model_transmission_type,true);
		$criteria->compare('model_seats',$this->model_seats);
		$criteria->compare('model_doors',$this->model_doors);
		$criteria->compare('model_weight_kg',$this->model_weight_kg);
		$criteria->compare('model_length_mm',$this->model_length_mm);
		$criteria->compare('model_width_mm',$this->model_width_mm);
		$criteria->compare('model_height_mm',$this->model_height_mm);
		$criteria->compare('model_wheelbase_mm',$this->model_wheelbase_mm);
		$criteria->compare('model_lkm_hwy',$this->model_lkm_hwy,true);
		$criteria->compare('model_lkm_mixed',$this->model_lkm_mixed,true);
		$criteria->compare('model_lkm_city',$this->model_lkm_city,true);
		$criteria->compare('model_fuel_cap_l',$this->model_fuel_cap_l);
		$criteria->compare('model_sold_in_us',$this->model_sold_in_us);
		$criteria->compare('model_co2',$this->model_co2);
		$criteria->compare('model_make_display',$this->model_make_display,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CarQuery the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
