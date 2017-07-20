<?php

/**
 * This is the model class for table "building_pdf_upload".
 *
 * The followings are the available columns in table 'building_pdf_upload':
 * @property integer $upload_id
 * @property integer $building_id
 * @property string $title
 * @property string $note
 * @property string $file_name
 * @property string $file_size
 * @property integer $added_by
 * @property string $added_on
 */
class BuildingPdfUpload extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'building_pdf_upload';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('building_id, title, note, file_name, file_size, added_by, added_on', 'required'),
			array('building_id, added_by', 'numerical', 'integerOnly'=>true),
			array('title, file_name', 'length', 'max'=>255),
			array('file_size', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('upload_id, building_id, title, note, file_name, file_size, added_by, added_on', 'safe', 'on'=>'search'),
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
			'upload_id' => 'Upload',
			'building_id' => 'Building',
			'title' => 'Title',
			'note' => 'Note',
			'file_name' => 'File Name',
			'file_size' => 'File Size',
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

		$criteria->compare('upload_id',$this->upload_id);
		$criteria->compare('building_id',$this->building_id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('note',$this->note,true);
		$criteria->compare('file_name',$this->file_name,true);
		$criteria->compare('file_size',$this->file_size,true);
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
	 * @return BuildingPdfUpload the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
