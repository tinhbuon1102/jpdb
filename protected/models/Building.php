<?php

/**
 * This is the model class for table "building".
 *
 * The followings are the available columns in table 'building':
 * @property integer $building_id
 * @property string $name
 * @property string $old_name
 * @property string $name_kana
 * @property string $address
 * @property integer $faced_street_id
 * @property integer $construction_type_id
 * @property string $floor_scale
 * @property integer $earth_quake_res_std
 * @property string $earth_quake_res_std_note
 * @property string $emr_power_gen
 * @property string $built_year
 * @property string $renewal_data
 * @property string $std_floor_space
 * @property string $total_floor_space
 * @property string $elevator
 * @property string $elevator_non_stop
 * @property string $elevator_hall
 * @property string $entrance_with_attention
 * @property string $ent_op_cl_time
 * @property string $ent_auto_lock
 * @property string $parking_unit_no
 * @property string $limit_of_usage_time
 * @property string $wholesale_lease
 * @property integer $security_id
 * @property integer $form_type_id
 * @property integer $condominium_ownership
 * @property integer $sortOrder 
 */
class Building extends CActiveRecord
{
	private $floors;
	
	public function setFloors ($floors)
	{
		$this->floors = $floors;
	}
	
	public function getFloors ()
	{
		return $this->floors;
	}
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'building';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, old_name, name_kana, address, faced_street_id, construction_type_id, construction_type_name, floor_scale, earth_quake_res_std, earth_quake_res_std_note, emr_power_gen, built_year, renewal_data,renewal_data_en, std_floor_space, total_floor_space, elevator, elevator_non_stop, elevator_hall, entrance_with_attention, ent_op_cl_time, ent_auto_lock, parking_unit_no, limit_of_usage_time, wholesale_lease, security_id, form_type_id, condominium_ownership', 'required'),
			array('faced_street_id, construction_type_id, earth_quake_res_std, security_id, form_type_id, condominium_ownership, sortOrder', 'numerical', 'integerOnly'=>true),
			array('name, old_name, name_kana, floor_scale, earth_quake_res_std_note, renewal_data, ent_op_cl_time', 'length', 'max'=>255),
			array('emr_power_gen, built_year, limit_of_usage_time', 'length', 'max'=>50),
			array('std_floor_space, elevator', 'length', 'max'=>30),
			array('total_floor_space, elevator_non_stop, elevator_hall, entrance_with_attention, ent_auto_lock', 'length', 'max'=>20),
			array('parking_unit_no', 'length', 'max'=>100),
			array('wholesale_lease', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('building_id, buildingId, name, old_name, name_kana, address, faced_street_id, construction_type_id, floor_scale, earth_quake_res_std, earth_quake_res_std_note, emr_power_gen, built_year, renewal_data, std_floor_space, total_floor_space, elevator, elevator_non_stop, elevator_hall, entrance_with_attention, ent_op_cl_time, ent_auto_lock, parking_unit_no, limit_of_usage_time, wholesale_lease, security_id, form_type_id, condominium_ownership,sortOrder', 'safe', 'on'=>'search'),
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
// 			'f'=>array(self::HAS_MANY, 'Floor', 'building_id',  'joinType' => 'LEFT JOIN'), 
// 			'bs'=>array(self::HAS_MANY, 'BuildingStation', 'building_id', 'joinType' => 'LEFT JOIN'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'building_id' => 'Building',
			'name' => 'Name',
			'old_name' => 'Old Name',
			'name_kana' => 'Name Kana',
			'address' => 'Address',
			'faced_street_id' => 'Faced Street',
			'construction_type_id' => 'Construction Type',
			'floor_scale' => 'Floor Scale',
			'earth_quake_res_std' => 'Earth Quake Res Std',
			'earth_quake_res_std_note' => 'Earth Quake Res Std Note',
			'emr_power_gen' => 'Emr Power Gen',
			'built_year' => 'Built Year',
			'renewal_data' => 'Renewal Data',
			'renewal_data_en' => 'Renewal Data English',
			'std_floor_space' => 'Std Floor Space',
			'total_floor_space' => 'Total Floor Space',
			'elevator' => 'Elevator',
			'elevator_non_stop' => 'Elevator Non Stop',
			'elevator_hall' => 'Elevator Hall',
			'entrance_with_attention' => 'Entrance With Attention',
			'ent_op_cl_time' => 'Ent Op Cl Time',
			'ent_auto_lock' => 'Ent Auto Lock',
			'parking_unit_no' => 'Parking Unit No',
			'limit_of_usage_time' => 'Limit Of Usage Time',
			'wholesale_lease' => 'Wholesale Lease',
			'security_id' => 'Security',
			'form_type_id' => 'Form Type',
			'condominium_ownership' => 'Condominium Ownership',
			'sortOrder' => 'sortOrder'
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

		$criteria->compare('building_id',$this->building_id);
		$criteria->compare('buildingId',$this->buildingId);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('old_name',$this->old_name,true);
		$criteria->compare('name_kana',$this->name_kana,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('faced_street_id',$this->faced_street_id);
		$criteria->compare('construction_type_id',$this->construction_type_id);
		$criteria->compare('floor_scale',$this->floor_scale,true);
		$criteria->compare('earth_quake_res_std',$this->earth_quake_res_std);
		$criteria->compare('earth_quake_res_std_note',$this->earth_quake_res_std_note,true);
		$criteria->compare('emr_power_gen',$this->emr_power_gen,true);
		$criteria->compare('built_year',$this->built_year,true);
		$criteria->compare('renewal_data',$this->renewal_data,true);
		$criteria->compare('renewal_data_en',$this->renewal_data_en,true);
		$criteria->compare('std_floor_space',$this->std_floor_space,true);
		$criteria->compare('total_floor_space',$this->total_floor_space,true);
		$criteria->compare('elevator',$this->elevator,true);
		$criteria->compare('elevator_non_stop',$this->elevator_non_stop,true);
		$criteria->compare('elevator_hall',$this->elevator_hall,true);
		$criteria->compare('entrance_with_attention',$this->entrance_with_attention,true);
		$criteria->compare('ent_op_cl_time',$this->ent_op_cl_time,true);
		$criteria->compare('ent_auto_lock',$this->ent_auto_lock,true);
		$criteria->compare('parking_unit_no',$this->parking_unit_no,true);
		$criteria->compare('limit_of_usage_time',$this->limit_of_usage_time,true);
		$criteria->compare('wholesale_lease',$this->wholesale_lease,true);
		$criteria->compare('security_id',$this->security_id);
		$criteria->compare('form_type_id',$this->form_type_id);
		$criteria->compare('condominium_ownership',$this->condominium_ownership);
		$criteria->order = 'sortOrder ASC';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => array(
				'pageSize' => 30,
			),
				
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Building the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public static function getBuildingList($params){
		$criteria = new CDbCriteria();
		if (isset($params['select']) && ($params['select']))
		{
			$criteria->select = $params['select'];
		}
		
		if (isset($params['where']) && !empty($params['where']))
		{
			foreach ($params['where'] as $key => $value)
			{
				$criteria->addInCondition($key, $value);
			}
		}
		
		if (isset($params['order']) && ($params['order']))
		{
			$criteria->order = $params['order'];
		}
		
		if (isset($params['group']) && ($params['group']))
		{
			$criteria->group= $params['group'];
		}
		
		if (isset($params['joins']) && ($params['joins']))
		{
			foreach ($params['joins'] as $key => $value)
			{
				$criteria->join = $value ;
			}
		}
		
// 		$criteria->with = array('f');
		$result = self::model()->findAll($criteria);
		return $result;
// 		echo '<pre>'; print_r($result);die;
	}
	
	
	public function getBuildingPicUrl($type_images, $type) {
		$image_types = array(
			'building_front' => '/../buildingPictures/front/',
			'building_entrance' => '/../buildingPictures/entrance/',
			'building_infront' => '/../buildingPictures/inFront/',
	
			'floor_bathroom' => '/../floorPictures/bathroom/',
			'floor_indoor' => '/../floorPictures/indoor/',
			'floor_kitchen' => '/../floorPictures/kitchen/',
			'floor_other' => '/../floorPictures/other/',
			'floor_prospect' => '/../floorPictures/prospect/',
			'floor_tenant' => '/../floorPictures/tenant/',
	
			'plan' => '/../planPictures/',
	
			'pdf' => '/../buildingPdfUploads/',
		);
	
		$images = array();
		foreach ($type_images as $image)
		{
			$real_image = realpath(Yii::app()->basePath . $image_types[$type] . $image);
			if (is_file($real_image))
			{
				$images[] = $real_image;
			}
		}
		
		return $images;
	}
	
	public function deleteBuildingImages($id) {
		$buildingPictures = BuildingPictures::model()->findAll('building_id = ' . (int)$id);
		$all_images = array();
		if (!empty($buildingPictures))
		{
			foreach ($buildingPictures as $buildingPictureRow)
			{
				$front_images = explode(',' , $buildingPictureRow->front_images);
				$entrance_images = explode(',' , $buildingPictureRow->entrance_images);
				$in_front_images = explode(',' , $buildingPictureRow->in_front_building_images);
	
				// get image urls
				$all_images = array_merge($all_images, $this->getBuildingPicUrl($front_images, 'building_front'));
				$all_images = array_merge($all_images, $this->getBuildingPicUrl($entrance_images, 'building_entrance'));
				$all_images = array_merge($all_images, $this->getBuildingPicUrl($in_front_images, 'building_infront'));
			}
		}
	
		$buildingPdfs = BuildingPdfUpload::model()->findAll('building_id = ' . (int)$id);
		if (!empty($buildingPdfs))
		{
			foreach ($buildingPdfs as $buildingPdfRow)
			{
				$building_pdfs = explode(',' , $buildingPdfRow->file_name);
				$all_images = array_merge($all_images, $this->getBuildingPicUrl($building_pdfs, 'pdf'));
			}
		}
		
		$buildingPlans = PlanPicture::model()->findAll('building_id = ' . (int)$id);
		if (!empty($buildingPlans))
		{
			foreach ($buildingPlans as $buildingPlanRow)
			{
				$building_pdfs = explode(',' , $buildingPlanRow->name);
				$all_images = array_merge($all_images, $this->getBuildingPicUrl($building_pdfs, 'plan'));
			}
		}
		
		foreach ($all_images as $image)
		{
			@unlink($image);
		}
		BuildingPictures::model()->deleteAll('building_id = '.(int)$id);
		BuildingPdfUpload::model()->deleteAll('building_id = '.(int)$id);
	}
}
