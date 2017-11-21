<?php

/**
 * This is the model class for table "Traders_his".
 *
 * The followings are the available columns in table 'traders':
 * @property integer $trader_id
 * @property string $trader_name
 * @property integer $is_active
 * @property integer $added_by
 * @property string $added_on
 * @property integer $modified_by
 * @property string $modified_on
 */
class Traders_his extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'traders_his';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('trader_name, added_by, added_on, modified_by, modified_on', 'required'),
			array('is_active, added_by, modified_by', 'numerical', 'integerOnly'=>true),
			array('trader_name', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('trader_id, trader_name, is_active, added_by, added_on, modified_by, modified_on', 'safe', 'on'=>'search'),
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
			'trader_id' => 'Trader',
			'trader_name' => 'Trader Name',
			'is_active' => 'Is Active',
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

		$criteria->compare('trader_id',$this->trader_id);
		$criteria->compare('trader_name',$this->trader_name,true);
		$criteria->compare('is_active',$this->is_active);
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
	 * @return Traders the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
