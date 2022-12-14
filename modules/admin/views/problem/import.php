<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model app\models\Problem */

$this->title = Yii::t('app', 'Import Problem');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Problems'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$maxFileSize = min(ini_get("upload_max_filesize"),ini_get("post_max_size"));
?>
<div class="problem-import">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>Only support from HUSTOJ</p>
    <hr>
    <?php if (extension_loaded('xml')): ?>
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'target' => '_blank']]) ?>

    <?= $form->field($model, 'problemFile')->fileInput()?>

    <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-success']) ?>

    <?php ActiveForm::end() ?>
    <?php else: ?>
        <p>服务器尚未开启 php-xml 扩展，请安装 php-xml 后再使用此功能。</p>
    <?php endif; ?>
</div>
