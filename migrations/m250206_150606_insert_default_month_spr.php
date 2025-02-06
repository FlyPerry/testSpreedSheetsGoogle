<?php

use yii\db\Migration;

/**
 * Class m250206_150606_insert_default_month_spr
 */
class m250206_150606_insert_default_month_spr extends Migration
{
    public function safeUp()
    {
        $months = [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ];

        // Вставка данных в таблицу budget_month
        foreach ($months as $month) {
            $this->insert('{{%budget_month}}', [
                'month' => $month,
            ]);
        }
    }

    public function safeDown()
    {
        $this->truncateTable('{{%budget_years}}');
    }
}
