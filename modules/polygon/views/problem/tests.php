<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\modules\polygon\models\Problem;

/* @var $this yii\web\View */
/* @var $model app\modules\polygon\models\Problem */
/* @var $solutionStatus array */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Problems'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['model'] = $model;

$files = $model->getDataFiles();
?>

<?php if (extension_loaded('zip')): ?>
    <p>
        <?= Html::a('Download all data', ['download-data', 'id' => $model->id], ['class' => 'btn btn-success']); ?>
    </p>
<?php else: ?>
    <p>
        The server does not enable the <code>php-zip</code> extension. If you need to download the test data, please install the <code>php-zip</code> extension.
    </p>
<?php endif; ?>
<div class="table-responsive">
    <table class="table table-bordered table-rank">
        <thead>
        <tr>
            <th width="80px">ID</th>
            <th>Verdict</th>
            <th>Time</th>
            <th>Memory</th>
            <th>Submit Time</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <th><?= Html::a($solutionStatus['id'], ['/polygon/problem/solution-detail', 'id' => $model->id, 'sid' => $solutionStatus['id']]) ?></th>
            <th><?= Problem::getResultList($solutionStatus['result']) ?></th>
            <th><?= $solutionStatus['time'] ?>MS</th>
            <th><?= $solutionStatus['memory'] ?>KB</th>
            <th><?= $solutionStatus['created_at'] ?></th>
        </tr>
        </tbody>
    </table>
</div>
<div class="row">
    <p>
        Standard input file format: <code>*.in</code><br>
        Upload all input data, then click RUN to generate output data based on the solution given in <?= Html::a(Yii::t('app', 'Solution'), ['/polygon/problem/solution', 'id' => $model->id]) ?>.
    </p>
    <?= \app\widgets\webuploader\MultiImage::widget() ?>
    <p> <br><?= Html::a(Yii::t('app', 'Run'), ['/polygon/problem/run', 'id' => $model->id], ['class' => 'btn btn-success']) ?></p>
    <p class="text-info">
        After the upload is complete, refresh the page to view the results
    </p>
    <hr>
</div>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6">
                <table class="table">
                    <caption>
                        Standard input file
                        <a href="<?= Url::toRoute(['/polygon/problem/deletefile', 'id' => $model->id,'name' => 'in']) ?>" onclick="return confirm('Are you sure you want to delete all input files?');">
                            Delete all input files
                        </a>
                    </caption>
                    <tr>
                        <th>File name</th>
                        <th>Size (bytes)</th>
                        <th>Created at</th>
                        <th>Action</th>
                        </tr>
                    <?php foreach ($files as $file): ?>
                        <?php
                        if (!strpos($file['name'], '.in'))
                            continue;
                        ?>
                        <tr>
                            <th><?= $file['name'] ?></th>
                            <th><?= $file['size'] ?></th>
                            <th><?= date('Y-m-d H:i', $file['time']) ?></th>
                            <th>
                                <a href="<?= Url::toRoute(['/polygon/problem/viewfile', 'id' => $model->id,'name' => $file['name']]) ?>"
                                   target="_blank"
                                   title="<?= Yii::t('app', 'View') ?>">
                                    <span class="glyphicon glyphicon-eye-open"></span>
                                </a>
                                &nbsp;
                                <a href="<?= Url::toRoute(['/polygon/problem/deletefile', 'id' => $model->id,'name' => $file['name']]) ?>"
                                   title="<?= Yii::t('app', 'Delete') ?>">
                                    <span class="glyphicon glyphicon-remove"></span>
                                </a>
                            </th>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table">
                    <caption>
                        Standard output file
                        <a href="<?= Url::toRoute(['/polygon/problem/deletefile', 'id' => $model->id, 'name' => 'out']) ?>" onclick="return confirm('Are you sure you want to delete all output files?');">
                            Delete all output files
                        </a>
                    </caption>
                    <tr>
                        <th>File name</th>
                        <th>Size (bytes)</th>
                        <th>Created at</th>
                        <th>Action</th>
                    </tr>
                    <?php foreach ($files as $file): ?>
                        <?php
                        if (!strpos($file['name'], '.out') && !strpos($file['name'], '.ans'))
                            continue;
                        ?>
                        <tr>
                            <th><?= $file['name'] ?></th>
                            <th><?= $file['size'] ?></th>
                            <th><?= date('Y-m-d H:i', $file['time']) ?></th>
                            <th>
                                <a href="<?= Url::toRoute(['/polygon/problem/viewfile', 'id' => $model->id,'name' => $file['name']]) ?>"
                                   target="_blank"
                                   title="<?= Yii::t('app', 'View') ?>">
                                    <span class="glyphicon glyphicon-eye-open"></span>
                                </a>
                                &nbsp;
                                <a href="<?= Url::toRoute(['/polygon/problem/deletefile', 'id' => $model->id,'name' => $file['name']]) ?>"
                                   title="<?= Yii::t('app', 'Delete') ?>">
                                    <span class="glyphicon glyphicon-remove"></span>
                                </a>
                            </th>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>
</div>
