<?php

/**
 * This is the model class for table "building_station".
 *
 * The followings are the available columns in table 'building_station':
 * @property integer $building_station_id
 * @property integer $building_id
 * @property string $prefecture
 * @property string $name
 * @property string $line
 * @property string $postal
 * @property string $distance
 * @property string $x
 * @property string $y
 * @property string $time
 */
class BuildingStation extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'building_station';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('building_id, prefecture, name, line, postal, distance, x, y, time', 'required'),
			array('building_id', 'numerical', 'integerOnly'=>true),
			array('postal, distance, time', 'length', 'max'=>20),
			array('x, y', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('building_station_id, building_id, prefecture, name, line, postal, distance, x, y, time', 'safe', 'on'=>'search'),
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
// 			'building'=>array(self::HAS_MANY, 'Building', 'building_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'building_station_id' => 'Building Station',
			'building_id' => 'Building',
			'prefecture' => 'Prefecture',
			'name' => 'Name',
			'line' => 'Line',
			'postal' => 'Postal',
			'distance' => 'Distance',
			'x' => 'X',
			'y' => 'Y',
			'time' => 'Time',
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

		$criteria->compare('building_station_id',$this->building_station_id);
		$criteria->compare('building_id',$this->building_id);
		$criteria->compare('prefecture',$this->prefecture,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('line',$this->line,true);
		$criteria->compare('postal',$this->postal,true);
		$criteria->compare('distance',$this->distance,true);
		$criteria->compare('x',$this->x,true);
		$criteria->compare('y',$this->y,true);
		$criteria->compare('time',$this->time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Get all Corporate by prefecture
	 * @param array $prefecture
	 * @return array Corporate
	 */
	public function getStationCorporateByPrefecture($prefecture)
	{
		$criteria = new CDbCriteria;
		$criteria->select = "*";
		$criteria->alias = 't';
		$criteria->compare('t.prefecture', $prefecture);
		$criteria->group = 't.corporate';
		$criteria->order = 't.corporate ASC';
		return self::model()->findAll($criteria);
	}
	
	/**
	 * Get all Lines by Corporate and prefecture
	 * @param array $prefecture
	 * @param array $coporate
	 * @return array $aLines
	 */
	public function getStationLinesByCoprateAndPrefecture($corporate, $prefecture)
	{
		$criteria = new CDbCriteria;
		$criteria->select = "*";
		$criteria->alias = 't';
		$criteria->compare('t.prefecture', $prefecture);
		$criteria->compare('t.corporate', $corporate);
		$criteria->group = 't.line';
		$criteria->order = 't.line ASC';
		return self::model()->findAll($criteria);
	}
	
	
	/**
	 * Get all station by line name
	 * @param array aLines
	 * @return array of building station
	 */
	public function getStationByLinesAndPrefecture($aLines = array(), $prefecture, $group = true)
	{
		$criteria = new CDbCriteria;
		$criteria->select = "*";
		$criteria->alias = 't';
		$criteria->compare('t.prefecture', $prefecture);
		if (!empty($aLines))
			$criteria->addInCondition('t.line', $aLines);
		if ($group)
			$criteria->group = 't.name';
		return self::model()->findAll($criteria);
	}
	
	public function getNearestStation($buildId){
		$getStations = $this->find('building_id = "'.$buildId.'" order by `time` ASC');
		return $getStations;
	}
	
	public function getNearestStations($buildId){
		$getStations = $this->findAll('building_id = "'.$buildId.'" GROUP BY name ASC order by `time` ASC');
		return $getStations;
	}
	
	
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return BuildingStation the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
