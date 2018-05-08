<?php

use yii\db\Migration;

/**
 * Handles the creation of table `image`.
 */
class m180430_070926_create_image_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('image', [
            'id' => $this->primaryKey(),
            'filePath' => $this->string(),
            'itemId' => $this->integer(15),
            'isMain' => $this->integer(2),
            'modelName' => $this->string(),
            'name' => $this->string(),
            'sort' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('image');
    }
}
