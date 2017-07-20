<?php

/**
 * This is the model class for table "market_equivalent_town".
 *
 * The followings are the available columns in table 'market_equivalent_town':
 * @property integer $market_equivalent_town_is
 * @property string $town_name
 * @property string $district_name
 * @property string $prefecture_name
 * @property string $f_h_range
 * @property string $h_t_range
 * @property string $t_above_range
 * @property string $added_date
 */
class MarketEquivalentTown extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'market_equivalent_town';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('town_name, district_name, prefecture_name, f_h_range, h_t_range, t_above_range, added_date', 'required'),
			array('town_name, district_name, prefecture_name, f_h_range, h_t_range, t_above_range', 'length', 'max'=>300),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('market_equivalent_town_is, town_name, district_name, prefecture_name, f_h_range, h_t_range, t_above_range, added_date', 'safe', 'on'=>'search'),
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
			'market_equivalent_town_is' => 'Market Equivalent Town Is',
			'town_name' => 'Town Name',
			'district_name' => 'District Name',
			'prefecture_name' => 'Prefecture Name',
			'f_h_range' => 'F H Range',
			'h_t_range' => 'H T Range',
			't_above_range' => 'T Above Range',
			'added_date' => 'Added Date',
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

		$criteria->compare('market_equivalent_town_is',$this->market_equivalent_town_is);
		$criteria->compare('town_name',$this->town_name,true);
		$criteria->compare('district_name',$this->district_name,true);
		$criteria->compare('prefecture_name',$this->prefecture_name,true);
		$criteria->compare('f_h_range',$this->f_h_range,true);
		$criteria->compare('h_t_range',$this->h_t_range,true);
		$criteria->compare('t_above_range',$this->t_above_range,true);
		$criteria->compare('added_date',$this->added_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MarketEquivalentTown the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
