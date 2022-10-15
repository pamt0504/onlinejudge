<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Contest */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Contest'), 'url' => ['/contest/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h2><?= Yii::t('app','Coming soon:')?> <?= Html::encode($model->title) ?></h2>

<h4><?= Yii::t('app','Entry Agreement')?></h4>
<p><?= Yii::t('app','1. Not sharing solutions with others')?></p>
<p><?= Yii::t('app','2. Do not destroy or attack the judge system')?></p>

<?= Html::a(Yii::t('app', 'Agree above and register'), ['/contest/register', 'id' => $model->id, 'register' => 1]) ?>
