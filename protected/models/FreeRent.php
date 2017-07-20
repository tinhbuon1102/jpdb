<?php

/**
 * This is the model class for table "free_rent".
 *
 * The followings are the available columns in table 'free_rent':
 * @property integer $free_rent_id
 * @property integer $building_id
 * @property integer $allocate_building_id
 * @property integer $free_rent
 * @property string $expiration_date
 * @property integer $added_by
 * @property string $added_on
 */
class FreeRent extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'free_rent';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('building_id, allocate_building_id, free_rent, expiration_date, added_by, added_on', 'required'),
			array('building_id, allocate_building_id, free_rent, added_by', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('free_rent_id, building_id, allocate_building_id, free_rent, expiration_date, added_by, added_on', 'safe', 'on'=>'search'),
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
			'free_rent_id' => 'Free Rent',
			'building_id' => 'Building',
			'allocate_building_id' => 'Allocate Building',
			'free_rent' => 'Free Rent',
			'expiration_date' => 'Expiration Date',
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

		$criteria->compare('free_rent_id',$this->free_rent_id);
		$criteria->compare('building_id',$this->building_id);
		$criteria->compare('allocate_building_id',$this->allocate_building_id);
		$criteria->compare('free_rent',$this->free_rent);
		$criteria->compare('expiration_date',$this->expiration_date,true);
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
	 * @return FreeRent the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
