<?php

namespace app\modules\admin\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\StringHelper;

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
//    Добавляем два свойства
    public $imageFile;
    public $imageFiles;
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
//            Добавляем правила для валидации
            [['imageFile'], 'file', 'extensions' => 'png, jpg, jpeg'],
            [['imageFiles'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg', 'maxFiles' => 10],
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
            'name' => 'Имя',
            'keywords' => 'Keywords',
            'description' => 'Description',
            'alias' => 'Alias',
            'content' => 'Content',
            'price' => 'Price',
            'hit' => 'Hit',
            'new' => 'New',
            'sale' => 'Sale',
            'imageFile' => 'Картинка',
        ];
    }

    //    ---- Получение списка категорий ----
    public function getCategoryList(){
        $categories = ArrayHelper::map(Category::find()->all(), 'id', 'name');
        return $categories;
    }

    //    ---- Загрузка одной картинки при создании ---
    public function uploadCreate($image)
    {
        $generated_name = strtolower(md5(uniqid($this->imageFile->baseName)));
        $name_model = StringHelper::basename(get_class($this));
        if ($this->validate()) {
            if($this->imageFile==!null){
                if(!file_exists('uploads/' . 'all-' .$name_model)){
                    mkdir('uploads/'. 'all-' .$name_model );
                    mkdir('uploads/'. 'all-' .$name_model . '/' . $name_model .$this->id);
                    $path = 'uploads/'. 'all-' .$name_model . '/'. $name_model .$this->id .'/'. $generated_name . '.' . $this->imageFile->extension;
                    $this->imageFile->saveAs($path);
                    return $path;

                }else{
                    if (!file_exists('uploads/'. 'all-' .$name_model .'/' . $name_model .$this->id)){
                        mkdir('uploads/'. 'all-' .$name_model .'/' . $name_model .$this->id);
                        $path = 'uploads/'. 'all-' .$name_model .'/' . $name_model .$this->id .'/'. $generated_name . '.' . $this->imageFile->extension;
                        $this->imageFile->saveAs($path);
                        return $path;
                    }
                }
            }
        }
    }

    //    Получение пути к одной картинки из таблицы картинок (image)
    public function getImage(){
        return $this->hasOne(Image::className(), ['itemId' => 'id']);
    }

    //    ---- Загрузка многих картинок при создании ---
    public function uploadsCreate($images)
    {
        $name_model = StringHelper::basename(get_class($this));

        if(!file_exists('uploads/'. 'all-' .$name_model)){
            mkdir('uploads/'. 'all-' .$name_model);
            mkdir('uploads/'. 'all-' .$name_model . '/' . $name_model .$this->id);
            foreach ($this->imageFiles as $file) {
                $generated_name = strtolower(md5(uniqid($file->baseName)));
                $path = 'uploads/'. 'all-' .$name_model . '/'. $name_model .$this->id .'/'. $generated_name . '.' . $file->extension;
                $file->saveAs($path);
                $pathtoarray[] = [$path];
            }
            return $pathtoarray;
        }elseif (file_exists('uploads/'. 'all-' .$name_model . '/' . $name_model .$this->id)){
            foreach ($this->imageFiles as $file) {
                $generated_name = strtolower(md5(uniqid($file->baseName)));
                $path = 'uploads/'. 'all-' .$name_model . '/'. $name_model .$this->id .'/'. $generated_name . '.' . $file->extension;
                $file->saveAs($path);
                $pathtoarray[] = [$path];
            }
            return $pathtoarray;
        }else{
            mkdir('uploads/'. 'all-' .$name_model . '/' . $name_model .$this->id);
            foreach ($this->imageFiles as $file) {
                $generated_name = strtolower(md5(uniqid($file->baseName)));
                $path = 'uploads/'. 'all-' .$name_model . '/'. $name_model .$this->id .'/'. $generated_name . '.' . $file->extension;
                $file->saveAs($path);
                $pathtoarray[] = [$path];
            }
            return $pathtoarray;
        }
    }

    //    Получение путей к картинкам из таблицы картинок (image)
    public function getImages(){
        return $this->hasMany(Image::className(), ['itemId' => 'id']);
    }

//    public function viewsImages(){
//        $images = $this->images;
////        debug($images);
//
//        foreach ($images as $image){
////            debug($image);
//            echo Html::img('/web/' . $image->filePath, ['width' => '100']);
//        }return true;
//    }























//    Загрузка картинки при обновлении
    public function uploadImage($fileimg, $currentimage)
    {

        if ($this->validate()) {

            $genfilename = strtolower(md5(uniqid($this->imageFile->baseName)));

            if($currentimage->filePath){
                unlink($currentimage->filePath);
            }

            if($this->imageFile==!null){
                if (!file_exists('uploads/Products/' . 'Product' .$this->id)){

                    mkdir('uploads/Products/' . 'Product' .$this->id);
                    $pathto = 'uploads/Products/' . 'Product' .$this->id .'/'. $genfilename . '.' . $this->imageFile->extension;
                    $this->imageFile->saveAs($pathto);
                    return $pathto;
                }else {
                    $pathto = 'uploads/Products/' . 'Product' . $this->id .'/'. $genfilename . '.' . $this->imageFile->extension;
                    $this->imageFile->saveAs($pathto);
                    return $pathto;
                }
            }
        } else {
            return false;
        }
    }



    public function beforeDelete()
    {
        $pathcurrentimag = Image::find()->andWhere(['itemId' => $this->id])->one();
        if($pathcurrentimag){
            unlink($pathcurrentimag->filePath);
            rmdir('uploads/Products/Product' . $this->id);
            $pathcurrentimag->delete();
        }

        return parent::beforeDelete(); // TODO: Change the autogenerated stub
    }


    public function uploadImages($filesimages)
    {
        if ($this->validate()) {

            if($this->imageFiles==!null){

                if (!file_exists('uploads/Products/' . 'Product' .$this->id)){
                    mkdir('uploads/Products/' . 'Product' .$this->id);
                    $pathtoarray = [];
                    foreach ($this->imageFiles as $file) {
//                        var_dump($this->imageFiles);
                        $genfilename = strtolower(md5(uniqid($file->baseName)));
                        $pathto = 'uploads/Products/' . 'Product' .$this->id .'/'. $genfilename . '.' . $file->extension;
                        $file->saveAs($pathto);
                        $pathtoarray[] = [$pathto];
                    }
                    return $pathtoarray;
//                    debug($pathtoarray);

                }else {
                    foreach ($this->imageFiles as $file) {
                        $genfilename = strtolower(md5(uniqid($file->baseName)));
                        $pathto = 'uploads/Products/' . 'Product' . $this->id .'/'. $genfilename . '.' . $file->extension;
                        $file->saveAs($pathto);
                    }
                    return $pathto;
                }
            }
            return true;
        } else {
            return false;
        }
    }
}
