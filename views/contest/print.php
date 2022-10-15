<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $newContestPrint app\models\ContestPrint */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $model->title;
$this->params['model'] = $model;

?>
<div class="print-source-index" style="margin-top: 20px">

    <div class="well">
        <?= Yii::t('app','Submit the content here, and the system will print it.')?>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'attribute' => 'id',
                'value' => function ($model, $key, $index, $column) {
                    return Html::a($model->id, ['/print/view', 'id' => $model->id], ['target' => '_blank']);
                },
                'format' => 'raw'
            ],
            'created_at:datetime',
            [
                'class' => 'yii\grid\ActionColumn',
                'controller' => 'print'
            ],
        ],
    ]); ?>

    <hr>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($newContestPrint, 'source')->widget('app\widgets\codemirror\CodeMirror'); ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app','Submit'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>