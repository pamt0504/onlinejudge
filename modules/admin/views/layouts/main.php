<?php
use yii\bootstrap\Nav;
?>

<?php $this->beginContent('@app/views/layouts/main.php'); ?>
<div class="col-md-2">
    <?= Nav::widget([
        'options' => ['class' => 'nav nav-pills nav-stacked'],
        'items' => [
            ['label' => 'Home', 'url' => ['/admin/default/index']],
            ['label' => 'News', 'url' => ['/admin/news/index']],
            ['label' => 'Problem', 'url' => ['/admin/problem/index']],
            ['label' => 'User', 'url' => ['/admin/user/index']],
            ['label' => 'Contest', 'url' => ['/admin/contest/index']],
            ['label' => 'Rejudge', 'url' => ['/admin/rejudge/index']],
            ['label' => 'Setting', 'url' => ['/admin/setting/index']],
            ['label' => 'Polygon System', 'url' => ['/polygon']]
        ],
    ]) ?>
</div>
<div class="col-md-10">
    <?= $content ?>
</div>
<?php $this->endContent(); ?>
<script type="text/javascript">
    $(document).ready(function () {
        var socket = io(document.location.protocol + '//' + document.domain + ':2120');
        var uid = <?= Yii::$app->user->isGuest ? session_id() : Yii::$app->user->id ?>;
            socket.on('connect', function () {
                socket.emit('login', uid);
            });
        socket.on('msg', function (msg) {
            alert(msg);
        });
    })
</script>
