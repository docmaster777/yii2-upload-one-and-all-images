<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "image".
 *
 * @property int $id
 * @property string $filePath
 * @property int $itemId
 * @property int $isMain
 * @property string $modelName
 * @property string $name
 * @property int $sort
 */
class Image extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'image';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['itemId', 'isMain', 'sort'], 'integer'],
            [['filePath', 'modelName', 'name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'filePath' => 'File Path',
            'itemId' => 'Item ID',
            'isMain' => 'Is Main',
            'modelName' => 'Model Name',
            'name' => 'Name',
            'sort' => 'Sort',
        ];
    }
}
