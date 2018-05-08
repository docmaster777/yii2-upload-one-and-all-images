<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property int $category_id
 * @property string $name
 * @property string $keywords
 * @property string $description
 * @property string $alias
 * @property string $content
 * @property double $price
 * @property int $hit
 * @property int $new
 * @property int $sale
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'hit', 'new', 'sale'], 'integer'],
            [['content'], 'string'],
            [['price'], 'number'],
            [['name', 'keywords', 'description', 'alias'], 'string', 'max' => 255],
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
            'keywords' => 'Keywords',
            'description' => 'Description',
            'alias' => 'Alias',
            'content' => 'Content',
            'price' => 'Price',
            'hit' => 'Hit',
            'new' => 'New',
            'sale' => 'Sale',
        ];
    }
}
