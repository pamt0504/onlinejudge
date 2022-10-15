<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Problem */

$this->title = Yii::t('app', $model->title);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Problems'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
$this->params['model'] = $model;
?>

<div class="problem-solution">
    <h1>
        <?= Html::encode($model->title) ?>
    </h1>
    <p>
        Write solution here.
    </p>
    <hr>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'solution')->widget('app\widgets\editormd\Editormd')->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
