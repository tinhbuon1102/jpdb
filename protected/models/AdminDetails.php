<?php

/**
 * This is the model class for table "admin_details".
 *
 * The followings are the available columns in table 'admin_details':
 * @property integer $admin_details_id
 * @property integer $user_id
 * @property string $full_name
 * @property string $joining_date
 * @property string $address
 * @property string $contact_number
 * @property string $email
 */
class AdminDetails extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'admin_details';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, full_name, joining_date, address, contact_number, email', 'required'),
			array('user_id', 'numerical', 'integerOnly'=>true),
			array('full_name', 'length', 'max'=>255),
			array('contact_number', 'length', 'max'=>15),
			array('email', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('admin_details_id, user_id, full_name, joining_date, address, contact_number, email', 'safe', 'on'=>'search'),
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
			'admin_details_id' => 'Admin Details',
			'user_id' => 'User',
			'full_name' => 'Full Name',
			'joining_date' => 'Joining Date',
			'address' => 'Address',
			'contact_number' => 'Contact Number',
			'email' => 'Email',
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

		$criteria->compare('admin_details_id',$this->admin_details_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('full_name',$this->full_name,true);
		$criteria->compare('joining_date',$this->joining_date,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('contact_number',$this->contact_number,true);
		$criteria->compare('email',$this->email,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AdminDetails the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
