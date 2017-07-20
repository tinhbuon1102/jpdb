<?php

/**
 * This is the model class for table "building_pictures".
 *
 * The followings are the available columns in table 'building_pictures':
 * @property integer $building_pictures_id
 * @property integer $building_id
 * @property string $front_images
 * @property string $entrance_images
 * @property string $in_front_building_images
 * @property integer $added_by
 * @property string $added_on
 */
class BuildingPictures extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'building_pictures';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('building_id, front_images, entrance_images, in_front_building_images, added_by, added_on', 'required'),
			array('building_id, added_by', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('building_pictures_id, building_id, front_images, entrance_images, in_front_building_images, added_by, added_on', 'safe', 'on'=>'search'),
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
			'building_pictures_id' => 'Building Pictures',
			'building_id' => 'Building',
			'front_images' => 'Front Images',
			'entrance_images' => 'Entrance Images',
			'in_front_building_images' => 'In Front Building Images',
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

		$criteria->compare('building_pictures_id',$this->building_pictures_id);
		$criteria->compare('building_id',$this->building_id);
		$criteria->compare('front_images',$this->front_images,true);
		$criteria->compare('entrance_images',$this->entrance_images,true);
		$criteria->compare('in_front_building_images',$this->in_front_building_images,true);
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
	 * @return BuildingPictures the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
