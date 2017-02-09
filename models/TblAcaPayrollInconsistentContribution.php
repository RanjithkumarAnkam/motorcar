<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_aca_payroll_inconsistent_contribution".
 *
 * @property integer $emp_inconsistent_id
 * @property integer $employee_id
 * @property string $january
 * @property string $febuary
 * @property string $march
 * @property string $april
 * @property string $may
 * @property string $june
 * @property string $july
 * @property string $august
 * @property string $september
 * @property string $october
 * @property string $november
 * @property string $december
 * @property integer $created_by
 * @property string $created_date
 * @property integer $modified_by
 * @property string $modified_date
 *
 * @property TblAcaPayrollData $employee
 */
class TblAcaPayrollInconsistentContribution extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_aca_payroll_inconsistent_contribution';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['employee_id', 'created_by'], 'required'],
            [['employee_id', 'created_by', 'modified_by'], 'integer'],
            [['january', 'febuary', 'march', 'april', 'may', 'june', 'july', 'august', 'september', 'october', 'november', 'december'], 'number'],
            [['created_date', 'modified_date'], 'safe'],
            [['employee_id'], 'exist', 'skipOnError' => true, 'targetClass' => TblAcaPayrollData::className(), 'targetAttribute' => ['employee_id' => 'employee_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'emp_inconsistent_id' => 'Emp Inconsistent ID',
            'employee_id' => 'Employee ID',
            'january' => 'January',
            'febuary' => 'Febuary',
            'march' => 'March',
            'april' => 'April',
            'may' => 'May',
            'june' => 'June',
            'july' => 'July',
            'august' => 'August',
            'september' => 'September',
            'october' => 'October',
            'november' => 'November',
            'december' => 'December',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'modified_by' => 'Modified By',
            'modified_date' => 'Modified Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployee()
    {
        return $this->hasOne(TblAcaPayrollData::className(), ['employee_id' => 'employee_id']);
    }
}
