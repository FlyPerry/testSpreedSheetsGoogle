<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "budget_entries".
 *
 * @property int $id
 * @property int $product_id
 * @property int $year_id
 * @property int $month_id
 * @property float|null $amount
 *
 * @property BudgetMonth $month
 * @property BudgetProducts $product
 * @property BudgetYears $year
 */
class BudgetEntries extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'budget_entries';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'year_id', 'month_id'], 'required'],
            [['product_id', 'year_id', 'month_id'], 'integer'],
            [['amount'], 'number'],
            [['month_id'], 'exist', 'skipOnError' => true, 'targetClass' => BudgetMonth::class, 'targetAttribute' => ['month_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => BudgetProducts::class, 'targetAttribute' => ['product_id' => 'id']],
            [['year_id'], 'exist', 'skipOnError' => true, 'targetClass' => BudgetYears::class, 'targetAttribute' => ['year_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'year_id' => 'Year ID',
            'month_id' => 'Month ID',
            'amount' => 'Amount',
        ];
    }

    /**
     * Gets query for [[Month]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMonth()
    {
        return $this->hasOne(BudgetMonth::class, ['id' => 'month_id']);
    }

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(BudgetProducts::class, ['id' => 'product_id']);
    }

    /**
     * Gets query for [[Year]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getYear()
    {
        return $this->hasOne(BudgetYears::class, ['id' => 'year_id']);
    }
}
