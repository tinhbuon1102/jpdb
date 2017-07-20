<?php

/**
 * This is the model class for table "prefecture".
 *
 * The followings are the available columns in table 'prefecture':
 * @property integer $prefecture_id
 * @property string $prefecture_name
 * @property integer $code
 */
class Prefecture extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'prefecture';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('prefecture_name, code', 'required'),
			array('code', 'numerical', 'integerOnly'=>true),
			array('prefecture_name', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('prefecture_id, prefecture_name, code', 'safe', 'on'=>'search'),
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
			'prefecture_id' => 'Prefecture',
			'prefecture_name' => 'Prefecture Name',
			'code' => 'Code',
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

		$criteria->compare('prefecture_id',$this->prefecture_id);
		$criteria->compare('prefecture_name',$this->prefecture_name,true);
		$criteria->compare('code',$this->code);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	/**
	 * Get all Prefecture by located building station by line name
	 * @param array aLines
	 * @return array of building station
	 */
	public function getAvailablePrefecture() {
		$criteria = new CDbCriteria;
		$criteria->select = "*";
		$criteria->alias = 't';
		$criteria->join = "INNER JOIN building_station bs ON t.prefecture_name = bs.prefecture ";
		$criteria->group = "t.prefecture_id";
		return self::model()->findAll($criteria);
	}
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Prefecture the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
