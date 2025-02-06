<?php

use yii\db\Migration;

/**
 * Class m250206_144658_create_budget_tables
 */
class m250206_144658_create_budget_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Таблица годов
        $this->createTable('{{%budget_years}}', [
            'id' => $this->primaryKey(),
            'year' => $this->integer()->notNull()->unique(),
        ]);

        $this->createTable('{{%budget_month}}', [
            'id' => $this->primaryKey(),
            'month' => $this->string()->notNull()->unique(),
        ]);

        // Таблица категорий бюджета
        $this->createTable('{{%budget_categories}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->unique(),
        ]);

        // Таблица продуктов
        $this->createTable('{{%budget_products}}', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
        ]);
        $this->addForeignKey('fk-product-category', '{{%budget_products}}', 'category_id', '{{%budget_categories}}', 'id', 'CASCADE');

        // Таблица бюджетных записей
        $this->createTable('{{%budget_entries}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'year_id' => $this->integer()->notNull(),
            'month_id' => $this->integer()->notNull(),
            'amount' => $this->decimal(10,2)->defaultValue(0),
        ]);
        $this->addForeignKey('fk-entry-product', '{{%budget_entries}}', 'product_id', '{{%budget_products}}', 'id', 'CASCADE');
        $this->addForeignKey('fk-entry-year', '{{%budget_entries}}', 'year_id', '{{%budget_years}}', 'id', 'CASCADE');
        $this->addForeignKey('fk-entry-month', '{{%budget_entries}}', 'month_id', '{{%budget_month}}', 'id', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropTable('{{%budget_entries}}');
        $this->dropTable('{{%budget_products}}');
        $this->dropTable('{{%budget_categories}}');
        $this->dropTable('{{%budget_years}}');
    }
}
