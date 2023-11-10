<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
$this->title = 'File Manager';
?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent mt-5 mb-5">
        <h1 class="display-4">File Manager</h1>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4 mb-3">

                <h2>Folders</h2>
                <?php foreach ($breadcrumbs as $item): ?>
                    <?php if(!$item['first']): ?>-&gt;<?php endif ?>
                    <?php if(!$item['last']): ?>
                        <a href="<?= Url::to(['files/index', 'path' => $item['path']]) ?>">
                            <?= Html::encode($item['label']) ?>
                        </a>
                    <?php else: ?>
                        <?= Html::encode($item['label']) ?>
                    <?php endif ?>
                <?php endforeach ?>

                <ul>
                    <?php foreach ($folders as $dir): ?>
                        <li><a href="<?= Url::to(['files/index', 'path' => "$path/$dir"]) ?>"><?= Html::encode($dir)?></a></li>
                    <?php endforeach ?>
                </ul>
                <?php
                $form = ActiveForm::begin(['method' => 'post', 'action' => '/files/mkdir']);
                ?>
                <?= $form->field($mkdirModel, 'dir')->label(false) ?>
                <?= $form->field($mkdirModel, 'path')->hiddenInput(['value'=> $path])->label(false); ?>
                <?= Html::submitButton('Create new folder', ['class' => 'btn btn-primary']) ?>
                <?php ActiveForm::end(); ?>

            </div>
            <div class="col-lg-4 mb-3">
                <h2>Files</h2>
                <ul>
                    <?php foreach ($files as $file): ?>
                        <li><?= Html::encode($file)?></li>
                    <?php endforeach ?>
                </ul>
            </div>
            <div class="col-lg-4">
            </div>
        </div>

    </div>
</div>





