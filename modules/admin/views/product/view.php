<?php

use app\modules\admin\models\Image;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Product */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
<!--    --><?php
//
//            $pathimg = $model->images;
//
//            foreach ($pathimg as $image){
//                echo Html::img('/web/' . $image->filePath, ['width' => '100']);
//            }
//
//
//    ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'category_id',
            'name',
            'keywords',
            'description',
            'alias',
            'content:ntext',
            'price',
            'hit',
            'new',
            'sale',
            [
                'format' => 'html',
                'label' => 'imageFile',
                'value' => function($data){
                    return Html::img('/web/' . $data->image->filePath, ['width' => '100']);
                }
            ],
            [
                'format' => 'html',
                'label' => 'imageFiles',
                'value' => foreach ($images as $image) {
                            echo Html::img('web/' . $image->filePath, ['width' => '100']);
                        }

            ],

        ],
    ]) ?>

</div>
