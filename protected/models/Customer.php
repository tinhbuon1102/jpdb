<?php

/**
 * This is the model class for table "customer".
 *
 * The followings are the available columns in table 'customer':
 * @property integer $customer_id
 * @property string $company_name
 * @property string $company_name_kana
 * @property string $president_name
 * @property string $postal_code
 * @property string $address
 * @property string $phone_no
 * @property string $fax_no
 * @property string $url
 * @property integer $business_type_id
 * @property integer $number_of_emp
 * @property integer $customer_source_id
 * @property integer $introducer_id
 * @property integer $inquiry_id
 * @property string $note
 * @property string $person_incharge_name
 * @property string $person_incharge_name_kana
 * @property string $position
 * @property string $branch_name
 * @property string $person_phone_no
 * @property string $person_fax_no
 * @property string $cellphone_no
 * @property string $email
 * @property string $department
 * @property integer $sales_staff_id
 * @property integer $added_by
 * @property string $added_on
 * @property integer $modified_by
 * @property string $modified_on
 */
class Customer extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'customer';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('company_name', 'required'),
			array('business_type_id, number_of_emp, customer_source_id, introducer_id, inquiry_id, sales_staff_id, added_by, modified_by', 'numerical', 'integerOnly'=>true),
			array('company_name, company_name_kana, president_name, url, note, person_incharge_name, person_incharge_name_kana, position, branch_name, department', 'length', 'max'=>255),
			array('postal_code, cellphone_no', 'length', 'max'=>20),
			array('phone_no, fax_no, person_phone_no, person_fax_no', 'length', 'max'=>30),
			array('email', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('customer_id, company_name, company_name_kana, president_name, postal_code, address, phone_no, fax_no, url, business_type_id, number_of_emp, customer_source_id, introducer_id, inquiry_id, note, person_incharge_name, person_incharge_name_kana, position, branch_name, person_phone_no, person_fax_no, cellphone_no, email, department, sales_staff_id, added_by, added_on, modified_by, modified_on', 'safe', 'on'=>'search'),
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
			'customer_id' => 'Customer',
			'company_name' => 'Company Name',
			'company_name_kana' => 'Company Name Kana',
			'president_name' => 'President Name',
			'postal_code' => 'Postal Code',
			'address' => 'Address',
			'phone_no' => 'Phone No',
			'fax_no' => 'Fax No',
			'url' => 'Url',
			'business_type_id' => 'Business Type',
			'number_of_emp' => 'Number Of Emp',
			'customer_source_id' => 'Customer Source',
			'introducer_id' => 'Introducer',
			'inquiry_id' => 'Inquiry',
			'note' => 'Note',
			'person_incharge_name' => 'Person Incharge Name',
			'person_incharge_name_kana' => 'Person Incharge Name Kana',
			'position' => 'Position',
			'branch_name' => 'Branch Name',
			'person_phone_no' => 'Person Phone No',
			'person_fax_no' => 'Person Fax No',
			'cellphone_no' => 'Cellphone No',
			'email' => 'Email',
			'department' => 'Department',
			'sales_staff_id' => 'Sales Staff',
			'added_by' => 'Added By',
			'added_on' => 'Added On',
			'modified_by' => 'Modified By',
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

		$criteria->compare('customer_id',$this->customer_id);
		$criteria->compare('company_name',$this->company_name,true);
		$criteria->compare('company_name_kana',$this->company_name_kana,true);
		$criteria->compare('president_name',$this->president_name,true);
		$criteria->compare('postal_code',$this->postal_code,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('phone_no',$this->phone_no,true);
		$criteria->compare('fax_no',$this->fax_no,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('business_type_id',$this->business_type_id);
		$criteria->compare('number_of_emp',$this->number_of_emp);
		$criteria->compare('customer_source_id',$this->customer_source_id);
		$criteria->compare('introducer_id',$this->introducer_id);
		$criteria->compare('inquiry_id',$this->inquiry_id);
		$criteria->compare('note',$this->note,true);
		$criteria->compare('person_incharge_name',$this->person_incharge_name,true);
		$criteria->compare('person_incharge_name_kana',$this->person_incharge_name_kana,true);
		$criteria->compare('position',$this->position,true);
		$criteria->compare('branch_name',$this->branch_name,true);
		$criteria->compare('person_phone_no',$this->person_phone_no,true);
		$criteria->compare('person_fax_no',$this->person_fax_no,true);
		$criteria->compare('cellphone_no',$this->cellphone_no,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('department',$this->department,true);
		$criteria->compare('sales_staff_id',$this->sales_staff_id);
		$criteria->compare('added_by',$this->added_by);
		$criteria->compare('added_on',$this->added_on,true);
		$criteria->compare('modified_by',$this->modified_by);
		$criteria->compare('modified_on',$this->modified_on,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Customer the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
