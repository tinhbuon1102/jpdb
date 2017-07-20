<?php

/**
 * This is the model class for table "customer_requirement".
 *
 * The followings are the available columns in table 'customer_requirement':
 * @property integer $customer_requirement_id
 * @property string $type_of_property
 * @property string $area
 * @property integer $area_group
 * @property string $reason_for_area
 * @property string $move_in_date
 * @property integer $reason_of_moving
 * @property string $current_rent_unit_price_per_tsubo
 * @property string $current_number_of_tsubo
 * @property string $number_of_tsubo
 * @property string $rent_price
 * @property integer $notice_of_cancellation
 * @property integer $parking
 * @property integer $number_of_floor
 * @property string $estimated_sales_amount
 * @property string $estimated_sales_date
 * @property string $comments
 */
class CustomerRequirement extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'customer_requirement';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('type_of_property, area, area_group, reason_for_area, move_in_date, reason_of_moving, current_rent_unit_price_per_tsubo, current_number_of_tsubo, number_of_tsubo, rent_price, notice_of_cancellation, parking, number_of_floor, estimated_sales_amount, estimated_sales_date, comments', 'required'),
			array('area_group, reason_of_moving, notice_of_cancellation, parking, number_of_floor', 'numerical', 'integerOnly'=>true),
			array('type_of_property, move_in_date, current_rent_unit_price_per_tsubo, current_number_of_tsubo, number_of_tsubo, rent_price, estimated_sales_amount, estimated_sales_date', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('customer_requirement_id, type_of_property, area, area_group, reason_for_area, move_in_date, reason_of_moving, current_rent_unit_price_per_tsubo, current_number_of_tsubo, number_of_tsubo, rent_price, notice_of_cancellation, parking, number_of_floor, estimated_sales_amount, estimated_sales_date, comments', 'safe', 'on'=>'search'),
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
			'customer_requirement_id' => 'Customer Requirement',
			'type_of_property' => 'Type Of Property',
			'area' => 'Area',
			'area_group' => 'Area Group',
			'reason_for_area' => 'Reason For Area',
			'move_in_date' => 'Move In Date',
			'reason_of_moving' => 'Reason Of Moving',
			'current_rent_unit_price_per_tsubo' => 'Current Rent Unit Price Per Tsubo',
			'current_number_of_tsubo' => 'Current Number Of Tsubo',
			'number_of_tsubo' => 'Number Of Tsubo',
			'rent_price' => 'Rent Price',
			'notice_of_cancellation' => 'Notice Of Cancellation',
			'parking' => 'Parking',
			'number_of_floor' => 'Number Of Floor',
			'estimated_sales_amount' => 'Estimated Sales Amount',
			'estimated_sales_date' => 'Estimated Sales Date',
			'comments' => 'Comments',
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

		$criteria->compare('customer_requirement_id',$this->customer_requirement_id);
		$criteria->compare('type_of_property',$this->type_of_property,true);
		$criteria->compare('area',$this->area,true);
		$criteria->compare('area_group',$this->area_group);
		$criteria->compare('reason_for_area',$this->reason_for_area,true);
		$criteria->compare('move_in_date',$this->move_in_date,true);
		$criteria->compare('reason_of_moving',$this->reason_of_moving);
		$criteria->compare('current_rent_unit_price_per_tsubo',$this->current_rent_unit_price_per_tsubo,true);
		$criteria->compare('current_number_of_tsubo',$this->current_number_of_tsubo,true);
		$criteria->compare('number_of_tsubo',$this->number_of_tsubo,true);
		$criteria->compare('rent_price',$this->rent_price,true);
		$criteria->compare('notice_of_cancellation',$this->notice_of_cancellation);
		$criteria->compare('parking',$this->parking);
		$criteria->compare('number_of_floor',$this->number_of_floor);
		$criteria->compare('estimated_sales_amount',$this->estimated_sales_amount,true);
		$criteria->compare('estimated_sales_date',$this->estimated_sales_date,true);
		$criteria->compare('comments',$this->comments,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CustomerRequirement the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
