<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Solution;

/* @var $this yii\web\View */
/* @var $model app\modules\polygon\models\Problem */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Problems'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['model'] = $model;

$model->setSamples();
?>


<?php if ($model->spj): ?>
    <p>
    Please fill in the special judgment procedure below. Refer to:<?= Html::a('Special Judge', ['/wiki/spj']) ?>
</p>
    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'spj_lang')->textInput([
        'maxlength' => true, 'value' => 'C、C++', 'disabled' => true
    ]) ?>

    <?= $form->field($model, 'spj_source')->widget('app\widgets\codemirror\CodeMirror'); ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
<?php else: ?>
    <p>The problem is not a SPJ judgment problem. If you want to enable the SPJ judgment for problem, please go to the editing page and change the Special Judge to Yes.</p>
<?php endif; ?>
