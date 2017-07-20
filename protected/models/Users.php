<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property integer $user_id
 * @property string $username
 * @property string $password
 * @property string $user_role
 * @property string $added_on
 * @property integer $added_by
 * @property integer $is_active
 * @property integer $Is_deleted
 * @property integer $company
 */
class Users extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, password, user_role, added_on, added_by', 'required'),
			array('added_by, is_active, Is_deleted, company', 'numerical', 'integerOnly'=>true),
			array('username, user_role', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('user_id, username, password, user_role, added_on, added_by, is_active, Is_deleted, company', 'safe', 'on'=>'search'),
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
			'user_id' => 'User',
			'username' => 'Username',
			'password' => 'Password',
			'user_role' => 'User Role',
			'added_on' => 'Added On',
			'added_by' => 'Added By',
			'is_active' => 'Is Active',
			'Is_deleted' => 'Is Deleted',
			'company' => 'Company',
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

		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('user_role',$this->user_role,true);
		$criteria->compare('added_on',$this->added_on,true);
		$criteria->compare('added_by',$this->added_by);
		$criteria->compare('is_active',$this->is_active);
		$criteria->compare('Is_deleted',$this->Is_deleted);
		$criteria->compare('company',$this->company);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Users the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

		public function addUserData($value){
		$userDetails = Users::model()->findByPk($value);
		//print_r($userDetails);die;
		$addedByUserName = Users::model()->findByPk($userDetails->added_by);
		
		//print_r($addedByUserName);die;
		return '<span>'.$addedByUserName->username.'</span>';
	}
	
	public function getUserFullName($value){
		$userDetails = AdminDetails::model()->findByAttributes(array('user_id'=>$value));
		if(isset($userDetails->full_name) && $userDetails->full_name != ""){
			$fullName = $userDetails->full_name;
		}else{
			$fullName = '';
		}
		return '<span>'.$fullName.'</span>';
	}
	
	public function getUserContact($value){
		$userDetails = AdminDetails::model()->findByAttributes(array('user_id'=>$value));
		if(isset($userDetails->contact_number) && $userDetails->contact_number != ""){
			$contact = $userDetails->contact_number;
		}else{
			$contact = '';
		}
		return '<span>'.$contact.'</span>';
	}
}
