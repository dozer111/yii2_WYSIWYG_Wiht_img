<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use vova07\imperavi\Widget;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Category */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-form">
    <img src="../upload/5abb72dcbfe3f.jpg" width="100px" height="100px" alt="">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'category_test')->widget(Widget::classname(), [

        'settings' => [

            'lang' => 'ru',

            'minHeight' => 300,

            'pastePlainText' => true,

            'buttonSource' => true,

            'plugins' => [

                'clips',

                'fullscreen',

                'imagemanager',

            ],

            'imageUpload' => Url::to( [ '/category/image-upload' ] ),

            'imageManagerJson' => Url::to( [ '/category/images-get' ] ),

        ]

    ]);?>
    <?= $form->field($model, 'category_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'category_parent')->textInput() ?>

    <?= $form->field($model, 'category_image')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>


</div>
