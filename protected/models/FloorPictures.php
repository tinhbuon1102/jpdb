<?php

/**
 * This is the model class for table "floor_pictures".
 *
 * The followings are the available columns in table 'floor_pictures':
 * @property integer $floor_pictures_id
 * @property integer $floor_id
 * @property string $indoor_image
 * @property string $kitchen_image
 * @property string $bathroom_image
 * @property string $prospect_image
 * @property string $other_image
 * @property integer $added_by
 * @property string $added_on
 */
class FloorPictures extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'floor_pictures';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('floor_id, indoor_image, kitchen_image, bathroom_image, prospect_image, other_image, added_by, added_on', 'required'),
			array('floor_id, added_by', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('floor_pictures_id, floor_id, indoor_image, kitchen_image, bathroom_image, prospect_image, other_image, added_by, added_on', 'safe', 'on'=>'search'),
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
			'floor_pictures_id' => 'Floor Pictures',
			'floor_id' => 'Floor',
			'indoor_image' => 'Indoor Image',
			'kitchen_image' => 'Kitchen Image',
			'bathroom_image' => 'Bathroom Image',
			'prospect_image' => 'Prospect Image',
			'other_image' => 'Other Image',
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

		$criteria->compare('floor_pictures_id',$this->floor_pictures_id);
		$criteria->compare('floor_id',$this->floor_id);
		$criteria->compare('indoor_image',$this->indoor_image,true);
		$criteria->compare('kitchen_image',$this->kitchen_image,true);
		$criteria->compare('bathroom_image',$this->bathroom_image,true);
		$criteria->compare('prospect_image',$this->prospect_image,true);
		$criteria->compare('other_image',$this->other_image,true);
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
	 * @return FloorPictures the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
