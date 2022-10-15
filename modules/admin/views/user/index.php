<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;

$this->title = Yii::t('app', 'Users');
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <hr>
    <p>
        <?php Modal::begin([
            'header' => '<h2>' . Yii::t('app', 'Create account automatically') . '</h2>',
            'toggleButton' => ['label' => Yii::t('app', 'Create account automatically'), 'class' => 'btn btn-success'],
        ]);?>
        <?php $form = ActiveForm::begin(['options' => ['target' => '_blank']]); ?>
        <blockquote><p class="hint-block">1. For each account corresponds to a line, including <code>username</code> and <code>password</code>, separated by spaces</p></blockquote>
        <blockquote><p class="hint-block">2. <code>username</code> can only contain numbers, letters, underscores, not pure numbers, and the length is between 4 and 32 characters</p></blockquote>
        <blockquote><p class="hint-block">3. <code>password</code> must be at least six digits</p></blockquote>

        <?= $form->field($generatorForm, 'names')->textarea(['rows' => 10])  ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Generate'), ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
        <?php Modal::end(); ?>

    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'options' => ['id' => 'grid'],
        'columns' => [
            [
                'class' => 'yii\grid\CheckboxColumn',
                'name' => 'id',
            ],
            'id',
            'username',
            'nickname',
            'email:email',
            [
                'attribute' => 'role',
                'value' => function ($model, $key, $index, $column) {
                    if ($model->role == \app\models\User::ROLE_PLAYER) {
                        return 'Contestant';
                    } else if ($model->role == \app\models\User::ROLE_USER) {
                        return 'Normal User';
                    } else if ($model->role == \app\models\User::ROLE_VIP) {
                        return 'VIP';
                    } else if ($model->role == \app\models\User::ROLE_ADMIN) {
                        return 'Administrator';
                    }
                    return 'not set';
                },
                'format' => 'raw'
            ],
            // 'status',
            // 'created_at',
            // 'updated_at',
            [
                'class' => 'yii\grid\ActionColumn',
                //'name' => 'action',
            ],
        ],
    ]);
    $this->registerJs('
    $("#general-user").on("click", function () {
        var keys = $("#grid").yiiGridView("getSelectedRows");
        $.post({
           url: "'.\yii\helpers\Url::to(['/admin/user/index', 'action' => \app\models\User::ROLE_USER]).'", 
           dataType: \'json\',
           data: {keylist: keys}
        });
    });
    $("#vip-user").on("click", function () {
        var keys = $("#grid").yiiGridView("getSelectedRows");
        $.post({
           url: "'.\yii\helpers\Url::to(['/admin/user/index', 'action' => \app\models\User::ROLE_VIP]).'", 
           dataType: \'json\',
           data: {keylist: keys}
        });
    });
    ');
    ?>
</div>
