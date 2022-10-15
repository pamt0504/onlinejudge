<?php

use yii\helpers\Html;
use app\models\Solution;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Problem */
/* @var $spjContent string */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Problems'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['model'] = $model;
?>
<div class="solutions-view">
    <h1>
        <?= Html::encode($model->title) ?>
    </h1>
    <?php if ($model->spj): ?>
        <p>
            Please fill in the special judgment procedure below. Refer to：<?= Html::a('Special Judge', ['/wiki/spj']) ?>
        </p>
        <hr>

        <?= Html::beginForm() ?>

        <div class="form-group">
            <?= Html::textInput('spjLang', 'C、C++', ['disabled' => true, 'class' => 'form-control']); ?>
            <p class="hint-block">Only supported for C/C++.</p>
        </div>

        <div class="form-group">
            <?= Html::label(Yii::t('app', 'Spj'), 'spj', ['class' => 'sr-only']) ?>

            <?= \app\widgets\codemirror\CodeMirror::widget(['name' => 'spjContent', 'value' => $spjContent]);  ?>
        </div>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary']) ?>
        </div>
        <?= Html::endForm(); ?>
    <?php else: ?>
        <p>The problem is not a SPJ judgment problem. If you want to enable the SPJ judgment for problem, please go to the editing page and change the Special Judge to Yes.</p>
    <?php endif; ?>
</div>
