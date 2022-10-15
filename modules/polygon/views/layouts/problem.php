<?php


use yii\bootstrap\Nav;
$problem = $this->params['model'];
?>
<?php $this->beginContent('@app/views/layouts/main.php'); ?>
<div class="col-md-2">
    <?= Nav::widget([
        'options' => ['class' => 'nav nav-pills nav-stacked'],
        'items' => [
            ['label' => Yii::t('app', 'Home'), 'url' => ['/admin/default/index']],
            ['label' => Yii::t('app', 'News'), 'url' => ['/admin/news/index']],
            ['label' => Yii::t('app', 'Problem'), 'url' => ['/admin/problem/index']],
            ['label' => Yii::t('app', 'User'), 'url' => ['/admin/user/index']],
            ['label' => Yii::t('app', 'Contest'), 'url' => ['/admin/contest/index']],
            ['label' => Yii::t('app', 'Rejudge'), 'url' => ['/admin/rejudge/index']],
            ['label' => Yii::t('app', 'Setting'), 'url' => ['/admin/setting/index']],
            ['label' => Yii::t('app', 'Polygon System'), 'url' => ['/polygon']],
            
        ],
    ]) ?>
</div>
<div class="col-md-10">
<div class="polygon-header">
    <?= Nav::widget([
        'options' => ['class' => 'nav nav-pills'],
        'items' => [
            ['label' => Yii::t('app', 'Preview'), 'url' => ['/polygon/problem/view', 'id' => $problem->id]],
            ['label' => Yii::t('app', 'Edit'), 'url' => ['/polygon/problem/update', 'id' => $problem->id]],
            ['label' => Yii::t('app', 'Solution'), 'url' => ['/polygon/problem/solution', 'id' => $problem->id]],
            ['label' => Yii::t('app', 'Answer'), 'url' => ['/polygon/problem/answer', 'id' => $problem->id]],
            ['label' => Yii::t('app', 'Special Judge'), 'url' => ['/polygon/problem/spj', 'id' => $problem->id]],
            ['label' => Yii::t('app', 'Tests Data'), 'url' => ['/polygon/problem/tests', 'id' => $problem->id]],
            ['label' => Yii::t('app', 'Verify Data'), 'url' => ['/polygon/problem/verify', 'id' => $problem->id]],
            ['label' => Yii::t('app', 'Subtask'), 'url' => ['/polygon/problem/subtask', 'id' => $problem->id]],
        ],
    ]) ?>
</div>
<hr>
<?= $content ?>
<?php $this->endContent(); ?>
