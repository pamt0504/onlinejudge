<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Group */

$this->title = $model->name;
?>
<div class="group-update">

    <h1><?= Html::a(Html::encode($this->title), ['/group/view', 'id' => $model->id]) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

    <hr>

    <?= Html::a(Yii::t('app','Delete Group'), ['/group/delete', 'id' => $model->id], [
        'class' => 'btn btn-danger',
        'data-confirm' => Yii::t('app','Are you sure you want to delete it?'),
        'data-method' => 'post',
    ]) ?>

</div>
