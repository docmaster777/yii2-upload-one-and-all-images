<?php

use yii\db\Migration;

/**
 * Handles the creation of table `product`.
 */
class m180429_143707_create_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('product', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer(10),
            'name' => $this->string(),
            'keywords' => $this->string(),
            'description' => $this->string(),
            'alias' => $this->string(),
            'content' => $this->text(),
            'price' => $this->float(),
            'hit' => $this->integer(3),
            'new' => $this->integer(3),
            'sale' => $this->integer(3),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('product');
    }
}
