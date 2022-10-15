<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Contest */
/* @var $form yii\widgets\ActiveForm */
/* @var $data array */

$this->title = Html::encode($model->title);
$this->params['model'] = $model;
?>
<div class="contest-editorial">
    <div style="padding: 50px">
        <?php
        if ($model->editorial != NULL) {
            echo Yii::$app->formatter->asMarkdown($model->editorial);
        } else {
            echo 'No editorial yet. Please come back later';
        }
        ?>
    </div>
</div>
