<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_aca_print_and_mail".
 *
 * @property integer $print_id
 * @property integer $form_id
 * @property string $print_requested_by
 * @property string $requested_date
 * @property integer $person_type
 * @property integer $no_of_forms
 * @property double $price_per_form
 * @property string $estimated_date
 * @property integer $expedite_print
 * @property double $expedite_processing_fee
 * @property double $total_processing_amount
 * @property integer $created_by
 * @property string $created_date
 * @property integer $is_printed
 *
 * @property TblAcaForms $from
 */
class TblAcaPrintAndMail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_aca_print_and_mail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['form_id', 'print_requested_by', 'created_by'], 'required'],
            [['form_id', 'print_requested_by', 'person_type','no_of_forms', 'expedite_print', 'created_by','is_printed'], 'integer'],
            [['requested_date', 'estimated_date', 'created_date'], 'safe'],
            [['price_per_form', 'expedite_processing_fee', 'package_and_shipping', 'total_processing_amount'], 'number'],
            [['form_id'], 'exist', 'skipOnError' => true, 'targetClass' => TblAcaForms::className(), 'targetAttribute' => ['form_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
     public function attributeLabels()
    {
        return [
            'print_id' => 'Print ID',
            'form_id' => 'From ID',
            'print_requested_by' => 'Print Requested By',
            'requested_date' => 'Requested Date',
			'person_type' => 'Person Type',
            'no_of_forms' => 'No Of Forms',
            'price_per_form' => 'Price Per Form',
            'estimated_date' => 'Estimated Date',
            'expedite_print' => 'Expedite Print',
            'expedite_processing_fee' => 'Expedite Processing Fee',
			'is_printed'=>'Printed',
			 'package_and_shipping' => 'Package And Shipping',
            'total_processing_amount' => 'Total Processing Amount',
			
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getForm()
    {
        return $this->hasOne(TblAcaForms::className(), ['id' => 'form_id']);
    }
	
	  public function getUsername()
    {
    	return $this->hasOne(TblAcaCompanyUsers::className(), ['user_id' => 'print_requested_by']);
    }
	
	public function findsumofforms($id)
    {
    	$model_sum = TblAcaPrintAndMail::find()
    	->where(['form_id'=>$id])
    	->sum('no_of_forms');
    	 
    	return $model_sum;
    }
	
	public function findtotalamount($id)
    {
    	$model_amount = TblAcaPrintAndMail::find()
    	->where(['form_id'=>$id])
    	->sum('total_processing_amount');
    	 
    	return $model_amount;
    }
	

}
