<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "budget_products".
 *
 * @property int $id
 * @property int $category_id
 * @property string $name
 *
 * @property BudgetEntries[] $budgetEntries
 * @property BudgetCategories $category
 */
class BudgetProducts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'budget_products';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'name'], 'required'],
            [['category_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => BudgetCategories::class, 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'name' => 'Name',
        ];
    }

    /**
     * Gets query for [[BudgetEntries]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBudgetEntries()
    {
        return $this->hasMany(BudgetEntries::class, ['product_id' => 'id']);
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(BudgetCategories::class, ['id' => 'category_id']);
    }
}
