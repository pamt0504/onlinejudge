<?php
use yii\helpers\Html;
$this->title = Yii::t('app', 'Setting');
?>

<div class="setting-form">
    <h1><?= Html::encode($this->title) ?></h1>

    <hr>
    <?= Html::beginForm() ?>

    <div class="form-group">
        <?= Html::label(Yii::t('app', 'OJ Name'), 'ojName') ?>
        <?= Html::textInput('ojName', $settings['ojName'], ['class' => 'form-control']) ?>
    </div>

    <div class="form-group">
        <?= Html::label(Yii::t('app', 'OI Mode'), 'oiMode') ?>
        <?= Html::radioList('oiMode', $settings['oiMode'], [
            1 => 'Yes',
            0 => 'No'
        ]) ?>
        <p class="hint-block">To enable OI mode, please go to the installation directory and run the command <code>sudo ./dispatcher -o</code>.</p>
    </div>

    <div class="form-group">
        <?= Html::label(Yii::t('app', 'School Name'), 'ojName') ?>
        <?= Html::textInput('schoolName', $settings['schoolName'], ['class' => 'form-control']) ?>
    </div>

    <div class="form-group">
        <?= Html::label(Yii::t('app', 'Do you want to share code?'), 'isShareCode') ?>
        <?= Html::radioList('isShareCode', $settings['isShareCode'], [
            1 => 'Share',
            0 => "Don't share"
        ]) ?>
    </div>

    <div class="form-group">
        <?= Html::label(Yii::t('app', 'Frozen Time'), 'scoreboardFrozenTime') ?>
 

        <?= Html::textInput('scoreboardFrozenTime', $settings['scoreboardFrozenTime'], ['class' => 'form-control']) ?>
        <p class="hint-block">This time is calculated from the end of the contest. If the value is 
            <?= $settings['scoreboardFrozenTime'] ?>s, it means that the scoreboard will show after <?= intval($settings['scoreboardFrozenTime'] / 3600) ?> hours the end of the contest.
        </p>
    </div>

    <hr>
    <div class="form-horizontal">
        <h4>Configure SMTP </h4>

        <div class="form-group">
            <?= Html::label('Valid time', 'passwordResetTokenExpire', ['class' => 'col-sm-2 control-label']) ?>
            <div class="col-sm-10">
                <?= Html::textInput('passwordResetTokenExpire', $settings['passwordResetTokenExpire'], ['class' => 'form-control']) ?>
            </div>
        </div>
        <div class="form-group">
            <?= Html::label('Verify your email?', 'mustVerifyEmail', ['class' => 'col-sm-2 control-label']) ?>
            <div class="col-sm-10">
                <?= Html::radioList('mustVerifyEmail', $settings['mustVerifyEmail'], [
                    1 => 'Yes',
                    0 => 'No'
                ]) ?>
            </div>
        </div>
        <div class="form-group">
            <?= Html::label('Host', 'emailHost', ['class' => 'col-sm-2 control-label']) ?>
            <div class="col-sm-10">
                <?= Html::textInput('emailHost', $settings['emailHost'], ['class' => 'form-control', 'placeholder' => 'smtp.exmail.qq.com']) ?>
            </div>
        </div>
        <div class="form-group">
            <?= Html::label('Username', 'emailUsername', ['class' => 'col-sm-2 control-label']) ?>
            <div class="col-sm-10">
                <?= Html::textInput('emailUsername', $settings['emailUsername'], ['class' => 'form-control', 'placeholder' => 'no-reply@truongt36.edu.vn']) ?>
            </div>
        </div>
        <div class="form-group">
            <?= Html::label('Password', 'emailPassword', ['class' => 'col-sm-2 control-label']) ?>
            <div class="col-sm-10">
                <?= Html::textInput('emailPassword', $settings['emailPassword'], ['class' => 'form-control', 'placeholder' => 'you_password']) ?>
            </div>
        </div>
        <div class="form-group">
            <?= Html::label('Port', 'emailPort', ['class' => 'col-sm-2 control-label']) ?>
            <div class="col-sm-10">
                <?= Html::textInput('emailPort', $settings['emailPort'], ['class' => 'form-control', 'placeholder' => '465']) ?>
            </div>
        </div>
        <div class="form-group">
            <?= Html::label('Encryption', 'emailEncryption', ['class' => 'col-sm-2 control-label']) ?>
            <div class="col-sm-10">
                <?= Html::textInput('emailEncryption', $settings['emailEncryption'], ['class' => 'form-control', 'placeholder' => 'ssl']) ?>
            </div>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary']) ?>
    </div>
    <?= Html::endForm(); ?>

</div>
