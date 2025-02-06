<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "budget_years".
 *
 * @property int $id
 * @property int $year
 *
 * @property BudgetEntries[] $budgetEntries
 */
class BudgetYears extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'budget_years';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['year'], 'required'],
            [['year'], 'integer'],
            [['year'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'year' => 'Year',
        ];
    }

    /**
     * Gets query for [[BudgetEntries]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBudgetEntries()
    {
        return $this->hasMany(BudgetEntries::class, ['year_id' => 'id']);
    }
}
