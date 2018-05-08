<?php

use yii\db\Migration;

/**
 * Handles the creation of table `category`.
 */
class m180429_143629_create_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('category', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer(10)->defaultValue(0),
            'name' => $this->string(),
            'keywords' => $this->string(),
            'description' => $this->string(),
            'alias' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('category');
    }
}
