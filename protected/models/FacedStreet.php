<?php

/**
 * This is the model class for table "faced_street".
 *
 * The followings are the available columns in table 'faced_street':
 * @property integer $faced_street_id
 * @property string $label
 * @property integer $parent_id
 * @property string $is_active
 * @property integer $added_by
 * @property string $add_on
 * @property integer $modified_by
 * @property string $modified_on
 */
class FacedStreet extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'faced_street';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('label, parent_id, added_by, add_on, modified_by, modified_on', 'required'),
			array('parent_id, added_by, modified_by', 'numerical', 'integerOnly'=>true),
			array('label', 'length', 'max'=>255),
			array('is_active', 'length', 'max'=>1),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('faced_street_id, label, parent_id, is_active, added_by, add_on, modified_by, modified_on', 'safe', 'on'=>'search'),
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
			'faced_street_id' => 'Faced Street',
			'label' => 'Label',
			'parent_id' => 'Parent',
			'is_active' => 'Is Active',
			'added_by' => 'Added By',
			'add_on' => 'Add On',
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

		$criteria->compare('faced_street_id',$this->faced_street_id);
		$criteria->compare('label',$this->label,true);
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('is_active',$this->is_active,true);
		$criteria->compare('added_by',$this->added_by);
		$criteria->compare('add_on',$this->add_on,true);
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
	 * @return FacedStreet the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
