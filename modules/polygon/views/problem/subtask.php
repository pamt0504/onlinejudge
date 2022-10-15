<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\polygon\models\Problem */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Problems'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['model'] = $model;

$model->setSamples();
?>
<p>
    You can config subtask below. Refer to: <?= Html::a('OI Mode', ['/wiki/oi']) ?>
</p>

<?php if (Yii::$app->setting->get('oiMode')): ?>
    

    <?= Html::beginForm() ?>

    <div class="form-group">
        <?= Html::label(Yii::t('app', 'Subtask'), 'subtaskContent', ['class' => 'sr-only']) ?>

        <?= \app\widgets\codemirror\CodeMirror::widget(['name' => 'subtaskContent', 'value' => $subtaskContent]);  ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary']) ?>
    </div>
    <?= Html::endForm(); ?>
<?php else: ?>
    <p>You need to enable OI mode on the settings page.</p>
<?php endif; ?>
