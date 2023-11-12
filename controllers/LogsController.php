<?php

namespace app\controllers;

use app\models\FilesLog;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;

class LogsController extends Controller
{
    public function actionIndex(): string
    {

        $dataProvider = new ActiveDataProvider([
            'query' => FilesLog::find(),
            'pagination' => [
                'pageSize' => 50,
            ],
        ]);
        /*
        $query = FilesLog::find();
        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count]);
        $logs = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        */
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);

    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => Yii::$app->user->getIdentity()->isAdmin(),
                    ],
                ],
            ],
        ];
    }

}
