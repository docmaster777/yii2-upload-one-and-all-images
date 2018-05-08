<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Product */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-form">
<!--    --><?php //debug($model->category_id); ?>

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'category_id')->dropDownList( $model->CategoryList, ['class'=>'form-control']) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'keywords')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'alias')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'price')->textInput() ?>

    <?= $form->field($model, 'hit')->textInput() ?>

    <?= $form->field($model, 'new')->textInput() ?>

    <?= $form->field($model, 'sale')->textInput() ?>

    <?= $form->field($model, 'imageFile')->fileInput() ?>

    <?= $form->field($model, 'imageFiles[]')->fileInput(['multiple' => true, 'accept' => 'image/*']) ?>

    <div class="view__product">
<!--        --><?php //var_dump($model->image->filePath) ?>
        <?  if($model->image->filePath){
            echo Html::img('/web/' . $model->image->filePath, ['width' => '100', 'class' => 'postImg']);
        } ?>

        <p style="display: none;" class="alert__text">Удалено</p>


        <?php   if($model->image->filePath){
            echo Html::a('<span class="glyphicon glyphicon-trash"></span>', ['product/deleteimage', 'id' => $model->id], [
                'onclick'=>
                    "$.ajax({
                    type:'POST',
                    cache: false,
                    url: '".Url::to(['product/deleteimage', 'id' => $model->id])."',
                    success  : function(response) {
                        $('.link-del').html(response);
                        $('.postImg').hide(300);
                        $('.alert__text').show('slow');
                        setTimeout(function() { $('.alert__text').hide('slow'); }, 2000);
                    }
                });
                return false;",
                'class' => 'link-del'
            ]);
        }

         ?>
    </div>




    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
