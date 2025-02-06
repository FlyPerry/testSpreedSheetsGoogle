<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "budget_categories".
 *
 * @property int $id
 * @property string $name
 *
 * @property BudgetProducts[] $budgetProducts
 */
class BudgetCategories extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'budget_categories';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * Gets query for [[BudgetProducts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBudgetProducts()
    {
        return $this->hasMany(BudgetProducts::class, ['category_id' => 'id']);
    }
}
