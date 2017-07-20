<?php

/**
 * This is the model class for table "market_area_info".
 *
 * The followings are the available columns in table 'market_area_info':
 * @property integer $market_area_info_id
 * @property integer $district_id
 * @property integer $town_id
 * @property string $area_discription
 * @property string $area_summary
 * @property string $area_landscape
 */
class MarketAreaInfo extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'market_area_info';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('district_id, town_id, area_discription, area_summary, area_landscape', 'required'),
			array('district_id, town_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('market_area_info_id, district_id, town_id, area_discription, area_summary, area_landscape', 'safe', 'on'=>'search'),
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
			'market_area_info_id' => 'Market Area Info',
			'district_id' => 'District',
			'town_id' => 'Town',
			'area_discription' => 'Area Discription',
			'area_summary' => 'Area Summary',
			'area_landscape' => 'Area Landscape',
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

		$criteria->compare('market_area_info_id',$this->market_area_info_id);
		$criteria->compare('district_id',$this->district_id);
		$criteria->compare('town_id',$this->town_id);
		$criteria->compare('area_discription',$this->area_discription,true);
		$criteria->compare('area_summary',$this->area_summary,true);
		$criteria->compare('area_landscape',$this->area_landscape,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MarketAreaInfo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
