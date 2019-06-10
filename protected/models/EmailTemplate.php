<?php

/**
 * This is the model class for table "tbl_email_template".
 *
 * The followings are the available columns in table 'tbl_email_template':
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property string $from
 * @property string $bcc
 * @property string $subject
 * @property string $html_head
 * @property string $html_body
 * @property string $bg_image_url
 * @property string $format_type
 * @property integer $account_id
 */
class EmailTemplate extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_email_template';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('code, name, format_type, account_id', 'required'),
			array('account_id', 'numerical', 'integerOnly'=>true),
			array('code', 'length', 'max'=>25),
			array('name, from', 'length', 'max'=>55),
			array('bcc, subject', 'length', 'max'=>145),
			array('html_head, html_body', 'length', 'max'=>255),
			array('format_type', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, code, name, from, bcc, subject, html_head, html_body, bg_image_url, format_type, account_id', 'safe', 'on'=>'search'),
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
			'code' => 'Code',
			'name' => 'Name',
			'from' => 'From',
			'bcc' => 'Bcc',
			'subject' => 'Subject',
			'html_head' => 'Html Head',
			'html_body' => 'Html Body',
			'bg_image_url' => 'Bg Image Url',
			'format_type' => 'Format Type',
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
		$criteria->compare('code',$this->code,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('from',$this->from,true);
		$criteria->compare('bcc',$this->bcc,true);
		$criteria->compare('subject',$this->subject,true);
		$criteria->compare('html_head',$this->html_head,true);
		$criteria->compare('html_body',$this->html_body,true);
		$criteria->compare('bg_image_url',$this->bg_image_url,true);
		$criteria->compare('format_type',$this->format_type,true);
		$criteria->compare('account_id',$this->account_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return EmailTemplate the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
