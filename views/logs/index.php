<?php
use \yii\grid\GridView;

/** @var yii\web\View $this */

$this->title = 'File manager logs';
?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent mt-5 mb-5">
        <h1 class="display-4"><?= $this->title ?></h1>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-md">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        'user_id',
                        'action',
                        'request',
                        'created_at:datetime',
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>
