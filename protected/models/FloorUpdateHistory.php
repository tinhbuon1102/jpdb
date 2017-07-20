<?php

/**
 * This is the model class for table "floor_update_history".
 *
 * The followings are the available columns in table 'floor_update_history':
 * @property integer $floor_update_history_id
 * @property integer $building_id
 * @property integer $floor_id
 * @property string $vacancy_info
 * @property string $rent_unit_price
 * @property string $unit_condo_fee
 * @property string $deposit_month
 * @property string $key_money_opt
 * @property integer $floor_source_id
 * @property string $confirmation
 * @property integer $update_person_in_charge
 * @property integer $property_confirmation_person
 * @property string $modified_on
 */
class FloorUpdateHistory extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'floor_update_history';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('building_id, floor_id, vacancy_info, rent_unit_price, unit_condo_fee, deposit_month, key_money_opt, floor_source_id, confirmation, update_person_in_charge, property_confirmation_person, modified_on', 'required'),
			array('building_id, floor_id, floor_source_id, update_person_in_charge, property_confirmation_person', 'numerical', 'integerOnly'=>true),
			array('vacancy_info, rent_unit_price, unit_condo_fee', 'length', 'max'=>30),
			array('deposit_month, key_money_opt', 'length', 'max'=>20),
			array('confirmation', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('floor_update_history_id, building_id, floor_id, vacancy_info, rent_unit_price, unit_condo_fee, deposit_month, key_money_opt, floor_source_id, confirmation, update_person_in_charge, property_confirmation_person, modified_on', 'safe', 'on'=>'search'),
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
			'floor_update_history_id' => 'Floor Update History',
			'building_id' => 'Building',
			'floor_id' => 'Floor',
			'vacancy_info' => 'Vacancy Info',
			'rent_unit_price' => 'Rent Unit Price',
			'unit_condo_fee' => 'Unit Condo Fee',
			'deposit_month' => 'Deposit Month',
			'key_money_opt' => 'Key Money Opt',
			'floor_source_id' => 'Floor Source',
			'confirmation' => 'Confirmation',
			'update_person_in_charge' => 'Update Person In Charge',
			'property_confirmation_person' => 'Property Confirmation Person',
			'modified_on' => 'Modified On',
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

		$criteria->compare('floor_update_history_id',$this->floor_update_history_id);
		$criteria->compare('building_id',$this->building_id);
		$criteria->compare('floor_id',$this->floor_id);
		$criteria->compare('vacancy_info',$this->vacancy_info,true);
		$criteria->compare('rent_unit_price',$this->rent_unit_price,true);
		$criteria->compare('unit_condo_fee',$this->unit_condo_fee,true);
		$criteria->compare('deposit_month',$this->deposit_month,true);
		$criteria->compare('key_money_opt',$this->key_money_opt,true);
		$criteria->compare('key_money_month',$this->key_money_month,true);
		$criteria->compare('floor_source_id',$this->floor_source_id);
		$criteria->compare('confirmation',$this->confirmation,true);
		$criteria->compare('update_person_in_charge',$this->update_person_in_charge);
		$criteria->compare('property_confirmation_person',$this->property_confirmation_person);
		$criteria->compare('modified_on',$this->modified_on,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Get all Floor by located building 
	 * @param array aLines
	 * @return array of building station
	 */
	public function getAvailableHistoryFloor($condition = '') {
		
		return Yii::app()->db->createCommand('
			SELECT * FROM district_tokyo LEFT JOIN (
				SELECT fh.*, b.district 
				FROM `floor_update_history` `fh` 
				INNER JOIN building b ON b.building_id = fh.building_id 
				'. ($condition ? 'WHERE ' . $condition : '')  .' GROUP BY fh.floor_id
			) as t on district_tokyo.`district_name` = t.district
		')->queryAll();
		
	}
	
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return FloorUpdateHistory the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
