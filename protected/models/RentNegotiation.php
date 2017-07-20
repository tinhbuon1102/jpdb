<?php

/**
 * This is the model class for table "rent_negotiation".
 *
 * The followings are the available columns in table 'rent_negotiation':
 * @property integer $rent_negotiation_id
 * @property integer $building_id
 * @property integer $negotiation_type
 * @property string $negotiation
 * @property string $allocate_floor_id
 * @property integer $person_incharge
 * @property integer $added_by
 * @property string $added_on
 * @property string $negotitation_note
 */
class RentNegotiation extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'rent_negotiation';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('building_id, negotiation_type, negotiation, allocate_floor_id, person_incharge, added_by, added_on, negotitation_note', 'required'),
			array('building_id, negotiation_type, person_incharge, added_by, negotitation_note', 'numerical', 'integerOnly'=>true),
			array('negotiation, allocate_floor_id', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('rent_negotiation_id, building_id, negotiation_type, negotiation, allocate_floor_id, person_incharge, added_by, added_on, negotitation_note', 'safe', 'on'=>'search'),
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
			'rent_negotiation_id' => 'Rent Negotiation',
			'building_id' => 'Building',
			'negotiation_type' => 'Negotiation Type',
			'negotiation' => 'Negotiation',
			'allocate_floor_id' => 'Allocate Floor',
			'person_incharge' => 'Person Incharge',
			'added_by' => 'Added By',
			'added_on' => 'Added On',
			'negotitation_note' => 'Note',				
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

		$criteria->compare('rent_negotiation_id',$this->rent_negotiation_id);
		$criteria->compare('building_id',$this->building_id);
		$criteria->compare('negotiation_type',$this->negotiation_type);
		$criteria->compare('negotiation',$this->negotiation,true);
		$criteria->compare('allocate_floor_id',$this->allocate_floor_id,true);
		$criteria->compare('person_incharge',$this->person_incharge);
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
	 * @return RentNegotiation the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
