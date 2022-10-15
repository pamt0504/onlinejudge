<?php

use yii\helpers\Html;

/* @var $model app\models\Contest */

$this->title = $model->title;
?>

<div class="wrap">
    <div class="container">
        <div class="row">
            <div class="col-md-3 text-left">
                <strong>Start </strong>
                <?= $model->start_time ?>
            </div>
            <div class="col-md-6 text-center">
                <h2 class="contest-title"><?= Html::a(Html::encode($model->title), ['/contest/view', 'id' => $model->id]) ?></h2>
            </div>
            <div class="col-md-3 text-right">
                <strong>End </strong>
                <?= $model->end_time ?>
            </div>
        </div>
        <?php echo $this->render('standing', [
            'model' => $model,
            'rankResult' => $rankResult,
            'showStandingBeforeEnd' => $showStandingBeforeEnd
        ]); ?> 
    </div>
</div>

<footer class="footer">
    <div class="text-center">
        <p class="text-info"> Contact me at: </p><p>   
        <a href="https://facebook.com/vietthientran.301"><img src="<?= Yii::getAlias('@web') ?>/facebook.ico"> Facebook   |   </a>
        <a href="https://www.youtube.com/channel/UCKenIExlFhPC0_ZC3kluKqQ"><img src="<?= Yii::getAlias('@web') ?>/youtube.ico"> Youtube   |   </a>
        <a href="https://www.github.com/Greenhat1998"><img src="<?= Yii::getAlias('@web') ?>/github.ico"> Github </a>
        </p>
    </div>
</footer>
