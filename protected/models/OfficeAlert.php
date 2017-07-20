<?php

/**
 * This is the model class for table "office_alert".
 *
 * The followings are the available columns in table 'office_alert':
 * @property integer $office_alert_id
 * @property string $proposed_article_name
 * @property string $building_id
 * @property integer $user_id
 * @property integer $customer_id
 * @property integer $office_alert_rand_id
 * @property integer $added_by
 * @property string $added_on
 */
class OfficeAlert extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'office_alert';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('proposed_article_name, building_id, user_id, customer_id, office_alert_rand_id, added_by, added_on', 'required'),
			array('user_id, customer_id, office_alert_rand_id, added_by', 'numerical', 'integerOnly'=>true),
			array('proposed_article_name, building_id', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('office_alert_id, proposed_article_name, building_id, user_id, customer_id, office_alert_rand_id, added_by, added_on', 'safe', 'on'=>'search'),
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
			'office_alert_id' => 'Office Alert',
			'proposed_article_name' => 'Proposed Article Name',
			'building_id' => 'Building',
			'user_id' => 'User',
			'customer_id' => 'Customer',
			'office_alert_rand_id' => 'Office Alert Rand',
			'added_by' => 'Added By',
			'added_on' => 'Added On',
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

		$criteria->compare('office_alert_id',$this->office_alert_id);
		$criteria->compare('proposed_article_name',$this->proposed_article_name,true);
		$criteria->compare('building_id',$this->building_id,true);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('customer_id',$this->customer_id);
		$criteria->compare('office_alert_rand_id',$this->office_alert_rand_id);
		$criteria->compare('added_by',$this->added_by);
		$criteria->compare('added_on',$this->added_on,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return OfficeAlert the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
