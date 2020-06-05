<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\GiiDemo */

$this->title = 'Create Gii Demo';
$this->params['breadcrumbs'][] = ['label' => 'Gii Demos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gii-demo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
