<?php

/**
 * This is the model class for table "plan_picture".
 *
 * The followings are the available columns in table 'plan_picture':
 * @property integer $plan_picture_id
 * @property string $name
 * @property integer $plan_rand_number
 * @property integer $added_by
 * @property string $added_on
 */
class PlanPicture extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'plan_picture';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, plan_rand_number, added_by, added_on', 'required'),
			array('plan_rand_number, added_by', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('plan_picture_id, name, plan_rand_number, added_by, added_on', 'safe', 'on'=>'search'),
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
			'plan_picture_id' => 'Plan Picture',
			'name' => 'Name',
			'plan_rand_number' => 'Plan Rand Number',
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

		$criteria->compare('plan_picture_id',$this->plan_picture_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('plan_rand_number',$this->plan_rand_number);
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
	 * @return PlanPicture the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
