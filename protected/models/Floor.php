<?php

/**
 * This is the model class for table "floor".
 *
 * The followings are the available columns in table 'floor':
 * @property integer $floor_id
 * @property integer $building_id
 * @property string $floor_rank
 * @property string $vacancy_info
 * @property string $move_in_date
 * @property integer $preceding_user
 * @property string $preceding_details
 * @property integer $preceding_check_datetime
 * @property string $vacant_schedule
 * @property string $floor_down
 * @property string $floor_up
 * @property string $roomname
 * @property integer $maisonette_type
 * @property integer $short_term_rent
 * @property integer $type_of_use
 * @property string $area_ping
 * @property string $area_m
 * @property string $area_net
 * @property integer $calculation_method
 * @property integer $payment_by_installments
 * @property string $payment_by_installments_note
 * @property string $floor_partition
 * @property integer $rent_unit_price_opt
 * @property string $rent_unit_price
 * @property string $total_rent_price
 * @property integer $unit_condo_fee_opt
 * @property string $unit_condo_fee
 * @property string $total_condo_fee
 * @property string $deposit_opt
 * @property string $deposit_month
 * @property string $deposit
 * @property string $total_deposit
 * @property string $key_money_opt
 * @property string $key_money_month
 * @property string $repayment_opt
 * @property integer $repayment_reason
 * @property string $repayment_amt
 * @property integer $repayment_amt_opt
 * @property integer $renewal_fee_opt
 * @property integer $renewal_fee_reason
 * @property string $renewal_fee_recent
 * @property integer $repayment_notes
 * @property string $notice_of_cancellation
 * @property integer $contract_period_opt
 * @property string $contract_period_duration
 * @property integer $air_conditioning_facility_type
 * @property string $air_conditioning_details
 * @property string $air_conditioning_time_used
 * @property integer $number_of_air_conditioning
 * @property string $optical_cable
 * @property integer $oa_type
 * @property string $oa_height
 * @property integer $floor_material
 * @property string $ceiling_height
 * @property string $electric_capacity
 * @property string $separate_toilet_by_gender
 * @property string $toilet_location
 * @property string $washlet
 * @property string $toilet_cleaning
 * @property string $notes
 * @property integer $floor_source_id
 * @property integer $update_person_in_charge
 * @property integer $property_confirmation_person
 * @property integer $is_condominium_ownership
 * @property integer $ownership_type
 * @property integer $management_type
 * @property string $owner_company_name
 * @property string $company_tel
 * @property string $person_in_charge1
 * @property string $person_in_charge2
 * @property string $charge
 */
class Floor extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'floor';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('air_conditioning_time_used', 'required'),
			array('building_id, preceding_user, maisonette_type, short_term_rent, calculation_method, payment_by_installments, rent_unit_price_opt, unit_condo_fee_opt,  repayment_amt_opt, renewal_fee_opt, renewal_fee_reason, contract_period_opt, number_of_air_conditioning,floor_source_id, update_person_in_charge, property_confirmation_person, integerOnly'=>true),
			array(' vacant_schedule, air_conditioning_time_used, owner_company_name, person_in_charge1, person_in_charge2, charge', 'length', 'max'=>255),
			array('vacancy_info, area_ping, area_m, area_net, floor_partition, rent_unit_price, unit_condo_fee, ceiling_height', 'length', 'max'=>30),
			array('move_in_date, roomname, total_deposit, air_conditioning_details', 'length', 'max'=>100),
			array('preceding_details', 'length', 'max'=>200),
			array('floor_down, floor_up, oa_height, separate_toilet_by_gender, toilet_location, washlet, toilet_cleaning, company_tel', 'length', 'max'=>20),
			array('payment_by_installments_note, total_rent_price, total_condo_fee, deposit, repayment_amt, renewal_fee_recent, contract_period_duration, electric_capacity', 'length', 'max'=>50),
			array('deposit_opt, deposit_month, key_money_opt, key_money_month, repayment_opt, notice_of_cancellation, optical_cable', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('floor_id, building_id, vacancy_info, move_in_date, preceding_user, preceding_details, preceding_check_datetime, vacant_schedule, floor_down, floor_up, roomname, maisonette_type, short_term_rent, type_of_use, area_ping, area_m, area_net, calculation_method, payment_by_installments, payment_by_installments_note, floor_partition, rent_unit_price_opt, rent_unit_price, total_rent_price, unit_condo_fee_opt, unit_condo_fee, total_condo_fee, deposit_opt, deposit_month, deposit, total_deposit, key_money_opt, key_money_month, repayment_opt, repayment_reason, repayment_amt, repayment_amt_opt, renewal_fee_opt, renewal_fee_reason, renewal_fee_recent, repayment_notes, notice_of_cancellation, contract_period_opt, contract_period_duration, air_conditioning_facility_type, air_conditioning_details, air_conditioning_time_used, number_of_air_conditioning, optical_cable, oa_type, oa_height, floor_material, ceiling_height, electric_capacity, separate_toilet_by_gender, toilet_location, washlet, toilet_cleaning, notes, floor_source_id, update_person_in_charge, property_confirmation_person, safe', 'on'=>'search'),
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
// 			'building'=>array(self::BELONGS_TO, 'Building', 'building_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'floor_id' => 'Floor',
			'building_id' => 'Building',
			'vacancy_info' => 'Vacancy Info',
			'move_in_date' => 'Move In Date',
			'preceding_user' => 'Preceding User',
			'preceding_details' => 'Preceding Details',
			'preceding_check_datetime' => 'Preceding Check Datetime',
			'vacant_schedule' => 'Vacant Schedule',
			'floor_down' => 'Floor Down',
			'floor_up' => 'Floor Up',
			'roomname' => 'Roomname',
			'maisonette_type' => 'Maisonette Type',
			'short_term_rent' => 'Short Term Rent',
			'type_of_use' => 'Type Of Use',
			'area_ping' => 'Area Ping',
			'area_m' => 'Area M',
			'area_net' => 'Area Net',
			'calculation_method' => 'Calculation Method',
			'payment_by_installments' => 'Payment By Installments',
			'payment_by_installments_note' => 'Payment By Installments Note',
			'floor_partition' => 'Floor Partition',
			'rent_unit_price_opt' => 'Rent Unit Price Opt',
			'rent_unit_price' => 'Rent Unit Price',
			'total_rent_price' => 'Total Rent Price',
			'unit_condo_fee_opt' => 'Unit Condo Fee Opt',
			'unit_condo_fee' => 'Unit Condo Fee',
			'total_condo_fee' => 'Total Condo Fee',
			'deposit_opt' => 'Deposit Opt',
			'deposit_month' => 'Deposit Month',
			'deposit' => 'Deposit',
			'total_deposit' => 'Total Deposit',
			'key_money_opt' => 'Key Money Opt',
			'key_money_month' => 'Key Money Month',
			'repayment_opt' => 'Repayment Opt',
			'repayment_reason' => 'Repayment Reason',
			'repayment_amt' => 'Repayment Amt',
			'repayment_amt_opt' => 'Repayment Amt Opt',
			'renewal_fee_opt' => 'Renewal Fee Opt',
			'renewal_fee_reason' => 'Renewal Fee Reason',
			'renewal_fee_recent' => 'Renewal Fee Recent',
			'repayment_notes' => 'Repayment Notes',
			'notice_of_cancellation' => 'Notice Of Cancellation',
			'contract_period_opt' => 'Contract Period Opt',
			'contract_period_duration' => 'Contract Period Duration',
			'air_conditioning_facility_type' => 'Air Conditioning Facility Type',
			'air_conditioning_details' => 'Air Conditioning Details',
			'air_conditioning_time_used' => 'Air Conditioning Time Used',
			'number_of_air_conditioning' => 'Number Of Air Conditioning',
			'optical_cable' => 'Optical Cable',
			'oa_type' => 'Oa Type',
			'oa_height' => 'Oa Height',
			'floor_material' => 'Floor Material',
			'ceiling_height' => 'Ceiling Height',
			'electric_capacity' => 'Electric Capacity',
			'separate_toilet_by_gender' => 'Separate Toilet By Gender',
			'toilet_location' => 'Toilet Location',
			'washlet' => 'Washlet',
			'toilet_cleaning' => 'Toilet Cleaning',
			'notes' => 'Notes',
			'floor_source_id' => 'Floor Source',
			'update_person_in_charge' => 'Update Person In Charge',
			'property_confirmation_person' => 'Property Confirmation Person',
			
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

		$criteria->compare('floor_id',$this->floor_id);
		$criteria->compare('building_id',$this->building_id);
		$criteria->compare('vacancy_info',$this->vacancy_info,true);
		$criteria->compare('move_in_date',$this->move_in_date,true);
		$criteria->compare('preceding_user',$this->preceding_user);
		$criteria->compare('preceding_details',$this->preceding_details,true);
		$criteria->compare('preceding_check_datetime',$this->preceding_check_datetime);
		$criteria->compare('vacant_schedule',$this->vacant_schedule,true);
		$criteria->compare('floor_down',$this->floor_down,true);
		$criteria->compare('floor_up',$this->floor_up,true);
		$criteria->compare('roomname',$this->roomname,true);
		$criteria->compare('maisonette_type',$this->maisonette_type);
		$criteria->compare('short_term_rent',$this->short_term_rent);
		$criteria->compare('type_of_use',$this->type_of_use);
		$criteria->compare('area_ping',$this->area_ping,true);
		$criteria->compare('area_m',$this->area_m,true);
		$criteria->compare('area_net',$this->area_net,true);
		$criteria->compare('calculation_method',$this->calculation_method);
		$criteria->compare('payment_by_installments',$this->payment_by_installments);
		$criteria->compare('payment_by_installments_note',$this->payment_by_installments_note,true);
		$criteria->compare('floor_partition',$this->floor_partition,true);
		$criteria->compare('rent_unit_price_opt',$this->rent_unit_price_opt);
		$criteria->compare('rent_unit_price',$this->rent_unit_price,true);
		$criteria->compare('total_rent_price',$this->total_rent_price,true);
		$criteria->compare('unit_condo_fee_opt',$this->unit_condo_fee_opt);
		$criteria->compare('unit_condo_fee',$this->unit_condo_fee,true);
		$criteria->compare('total_condo_fee',$this->total_condo_fee,true);
		$criteria->compare('deposit_opt',$this->deposit_opt,true);
		$criteria->compare('deposit_month',$this->deposit_month,true);
		$criteria->compare('deposit',$this->deposit,true);
		$criteria->compare('total_deposit',$this->total_deposit,true);
		$criteria->compare('key_money_opt',$this->key_money_opt,true);
		$criteria->compare('key_money_month',$this->key_money_month,true);
		$criteria->compare('repayment_opt',$this->repayment_opt,true);
		$criteria->compare('repayment_reason',$this->repayment_reason);
		$criteria->compare('repayment_amt',$this->repayment_amt,true);
		$criteria->compare('repayment_amt_opt',$this->repayment_amt_opt);
		$criteria->compare('renewal_fee_opt',$this->renewal_fee_opt);
		$criteria->compare('renewal_fee_reason',$this->renewal_fee_reason);
		$criteria->compare('renewal_fee_recent',$this->renewal_fee_recent,true);
		$criteria->compare('repayment_notes',$this->repayment_notes);
		$criteria->compare('notice_of_cancellation',$this->notice_of_cancellation,true);
		$criteria->compare('contract_period_opt',$this->contract_period_opt);
		$criteria->compare('contract_period_duration',$this->contract_period_duration,true);
		$criteria->compare('air_conditioning_facility_type',$this->air_conditioning_facility_type);
		$criteria->compare('air_conditioning_details',$this->air_conditioning_details,true);
		$criteria->compare('air_conditioning_time_used',$this->air_conditioning_time_used,true);
		$criteria->compare('number_of_air_conditioning',$this->number_of_air_conditioning);
		$criteria->compare('optical_cable',$this->optical_cable,true);
		$criteria->compare('oa_type',$this->oa_type);
		$criteria->compare('oa_height',$this->oa_height,true);
		$criteria->compare('floor_material',$this->floor_material);
		$criteria->compare('ceiling_height',$this->ceiling_height,true);
		$criteria->compare('electric_capacity',$this->electric_capacity,true);
		$criteria->compare('separate_toilet_by_gender',$this->separate_toilet_by_gender,true);
		$criteria->compare('toilet_location',$this->toilet_location,true);
		$criteria->compare('washlet',$this->washlet,true);
		$criteria->compare('toilet_cleaning',$this->toilet_cleaning,true);
		$criteria->compare('notes',$this->notes,true);
		$criteria->compare('floor_source_id',$this->floor_source_id);
		$criteria->compare('update_person_in_charge',$this->update_person_in_charge);
		$criteria->compare('property_confirmation_person',$this->property_confirmation_person);
		$criteria->compare('show_frontend',$this->show_frontend);
		

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => array(
				'pageSize' => 30,
			),
		));
	}

	/**
	 * Get all Floor by located building 
	 * @param array aLines
	 * @return array of building station
	 */
	public function getAvailableFloor($condition = '') {
		return Yii::app()->db->createCommand('
			SELECT * FROM district_tokyo LEFT JOIN (
				SELECT f.*, b.district 
				FROM `floor` `f` 
				INNER JOIN building b ON b.building_id = f.building_id 
				'. ($condition ? 'WHERE ' . $condition : '')  .' GROUP BY f.floor_id
			) as t on district_tokyo.`district_name` = t.district
		')->queryAll();
	}
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Floor the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getFloorPicUrl($type_images, $type) {
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
	
	public function deleteFloorImages($id) {
		$floorPictures = FloorPictures::model()->findAll('floor_id = ' . (int)$id);
		$all_images = array();
		if (!empty($floorPictures))
		{
			foreach ($floorPictures as $floorPictureRow)
			{
				$indoor_images = explode(',', $floorPictureRow->indoor_image);
				$kitchen_images = explode(',', $floorPictureRow->kitchen_image);
				$bathroom_images = explode(',', $floorPictureRow->bathroom_image);
				$prospect_images = explode(',', $floorPictureRow->prospect_image);
				$other_images = explode(',', $floorPictureRow->other_image);
				$tenant_list_images = explode(',', $floorPictureRow->tenant_list_image);
				
				// get image urls
				$all_images = array_merge($all_images, $this->getFloorPicUrl($indoor_images, 'floor_indoor'));
				$all_images = array_merge($all_images, $this->getFloorPicUrl($kitchen_images, 'floor_kitchen'));
				$all_images = array_merge($all_images, $this->getFloorPicUrl($bathroom_images, 'floor_bathroom'));
				$all_images = array_merge($all_images, $this->getFloorPicUrl($prospect_images, 'floor_prospect'));
				$all_images = array_merge($all_images, $this->getFloorPicUrl($other_images, 'floor_other'));
				$all_images = array_merge($all_images, $this->getFloorPicUrl($tenant_list_images, 'floor_tenant'));
			}
		}
	
		foreach ($all_images as $image)
		{
			@unlink($image);
		}
		FloorPictures::model()->deleteAll('floor_id = '.(int)$id);
	}
}
