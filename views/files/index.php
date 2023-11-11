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
        <p>Current folder:</p>
        <p class="lead">
            <?php foreach ($breadcrumbs as $item): ?>
                <?php if(!$item['first']): ?>/ <?php endif ?>
                <?php if(!$item['last']): ?>
                    <a href="<?= Url::to(['files/index', 'path' => $item['path']]) ?>">
                        <?= Html::encode($item['label']) ?>
                    </a>&nbsp;
                <?php else: ?>
                    <b><?= Html::encode($item['label']) ?></b>
                <?php endif ?>
            <?php endforeach ?>
        </p>
    </div>

    <div class="body-content">

        <div class="row">

            <div class="col-lg-4 mb-3">
                <h2>Manage</h2>
                <div class="form-group">
                    <?php $form = ActiveForm::begin(['method' => 'post', 'action' => 'files/folder/create']); ?>
                    <?= $form->field($folderModel, 'name')->label(false) ?>
                    <?= $form->field($folderModel, 'path')->hiddenInput(['value'=> $path])->label(false); ?>
                    <?= Html::submitButton('Create new folder', ['class' => 'btn btn-primary']) ?>
                    <?php ActiveForm::end(); ?>
                </div>
                <?php if($path !== "/"): ?>

                <div class="form-group">
                    <?php $form = ActiveForm::begin(['method' => 'post', 'action' => '/files/folder/rename']); ?>
                    <?= $form->field($folderModel, 'name')->label(false) ?>
                    <?= $form->field($folderModel, 'path')->hiddenInput(['value'=> $path])->label(false); ?>
                    <?= Html::submitButton('Rename this folder', ['class' => 'btn btn-primary']) ?>
                    <?php ActiveForm::end(); ?>
                </div>

                <div class="form-group">
                    <?php $form = ActiveForm::begin(['method' => 'post', 'action' => '/files/folder/delete']); ?>
                    <?= $form->field($folderModel, 'name')->hiddenInput(['value'=> 'dummy'])->label(false) ?>
                    <?= $form->field($folderModel, 'path')->hiddenInput(['value'=> $path])->label(false); ?>
                    <?= Html::submitButton('Delete this folder', ['class' => 'btn btn-primary']) ?>
                    <?= $form->field($folderModel, 'recursive')->checkbox(['label' => 'With all contents']); ?>

                    <?php ActiveForm::end(); ?>
                </div>

                <?php endif ?>
            </div>

            <div class="col-lg-4 mb-3">
                <h2>Folders</h2>
                <ul>
                    <?php foreach ($folders as $dir): ?>
                        <li>
                            <a href="<?= Url::to(['files/index', 'path' => "$path/$dir"]) ?>"><?= Html::encode($dir)?></a>
                        </li>
                    <?php endforeach ?>
                </ul>
            </div>

            <div class="col-lg-4">
                <h2>Files</h2>
                <ul>
                    <?php foreach ($files as $file): ?>
                        <li><?= Html::encode($file)?></li>
                    <?php endforeach ?>
                </ul>
            </div>

        </div>
    </div>
</div>

