<?php

/**
 * This is the model class for table "ownership_management".
 *
 * The followings are the available columns in table 'ownership_management':
 * @property integer $ownership_management_id
 * @property integer $floor_id
 * @property integer $is_condominium_ownership
 * @property integer $trader_id
 * @property integer $ownership_type
 * @property integer $management_type
 * @property string $owner_company_name
 * @property string $company_tel
 * @property string $person_in_charge1
 * @property string $person_in_charge2
 * @property string $charge
 * @property string $modified_on
 */
class OwnershipManagement extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ownership_management';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('floor_id, is_condominium_ownership, trader_id, ownership_type, management_type, owner_company_name, company_tel, person_in_charge1, person_in_charge2, charge, modified_on', 'required'),
			array('floor_id, is_condominium_ownership, trader_id, ownership_type, management_type', 'numerical', 'integerOnly'=>true),
			array('owner_company_name, person_in_charge1, person_in_charge2, charge', 'length', 'max'=>255),
			array('company_tel', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('ownership_management_id, floor_id, is_condominium_ownership, trader_id, ownership_type, management_type, owner_company_name, company_tel, person_in_charge1, person_in_charge2, charge, modified_on', 'safe', 'on'=>'search'),
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
			'ownership_management_id' => 'Ownership Management',
			'floor_id' => 'Floor',
			'is_condominium_ownership' => 'Is Condominium Ownership',
			'trader_id' => 'Trader',
			'ownership_type' => 'Ownership Type',
			'management_type' => 'Management Type',
			'owner_company_name' => 'Owner Company Name',
			'company_tel' => 'Company Tel',
			'person_in_charge1' => 'Person In Charge1',
			'person_in_charge2' => 'Person In Charge2',
			'charge' => 'Charge',
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

		$criteria->compare('ownership_management_id',$this->ownership_management_id);
		$criteria->compare('floor_id',$this->floor_id);
		$criteria->compare('is_condominium_ownership',$this->is_condominium_ownership);
		$criteria->compare('trader_id',$this->trader_id);
		$criteria->compare('ownership_type',$this->ownership_type);
		$criteria->compare('management_type',$this->management_type);
		$criteria->compare('owner_company_name',$this->owner_company_name,true);
		$criteria->compare('company_tel',$this->company_tel,true);
		$criteria->compare('person_in_charge1',$this->person_in_charge1,true);
		$criteria->compare('person_in_charge2',$this->person_in_charge2,true);
		$criteria->compare('charge',$this->charge,true);
		$criteria->compare('modified_on',$this->modified_on,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return OwnershipManagement the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
