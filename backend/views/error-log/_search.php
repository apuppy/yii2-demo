<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ErrorLogSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="error-log-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'module') ?>

    <?= $form->field($model, 'level') ?>

    <?= $form->field($model, 'code') ?>

    <?= $form->field($model, 'message') ?>

    <?php // echo $form->field($model, 'file') ?>

    <?php // echo $form->field($model, 'trace') ?>

    <?php // echo $form->field($model, 'created_date') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
