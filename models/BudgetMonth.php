<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "budget_month".
 *
 * @property int $id
 * @property string $month
 *
 * @property BudgetEntries[] $budgetEntries
 */
class BudgetMonth extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'budget_month';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['month'], 'required'],
            [['month'], 'string', 'max' => 255],
            [['month'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'month' => 'Month',
        ];
    }

    /**
     * Gets query for [[BudgetEntries]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBudgetEntries()
    {
        return $this->hasMany(BudgetEntries::class, ['month_id' => 'id']);
    }
}
