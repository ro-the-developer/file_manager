<?php

namespace app\controllers;

use app\models\MkdirForm;
use yii\helpers\Url;
use Yii;
use yii\helpers\FileHelper;
use yii\filters\AccessControl;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;


class FilesController extends Controller
{
    /**
     * Displays the main files page.
     *
     * @return string
     */
    public function actionIndex()
    {
        $path = $this->validatePath(Yii::$app->request->get('path', ''));
        $mkdirModel = new MkdirForm();
        $files = array_map('basename',
            FileHelper::findFiles(self::getBasePath() . $path, ['recursive' => false])
        );
        $folders = array_map('basename',
            FileHelper::findDirectories(self::getBasePath() . $path, ['recursive' => false])
        );

        return $this->render('index',[
            'mkdirModel' => $mkdirModel,
            'files' => $files,
            'folders' => $folders,
            'path' => $path,
            'breadcrumbs' => $this->getBreadcrumbs($path),
        ]);
    }

    public function actionMkdir()
    {
        $path = $this->validatePath(Yii::$app->request->post()['MkdirForm']['path']);
        $dir = Yii::$app->request->post()['MkdirForm']['dir'];
        $newDir = self::getBasePath() . $path . "/" . $dir;
        if (!mkdir($newDir) && !is_dir($newDir)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $newDir));
        }
        $this->redirect(Url::to(['files/index', 'path' => $path . "/" . $dir]), 302);
    }

    public static function getBasePath()
    {
        return Yii::$app->basePath . "/" . Yii::$app->params['filesModule']['path'];
    }

    protected function isPathValid($path)
    {
        return !preg_match('![^a-zA-Z0-9_/]!', $path) && file_exists(self::getBasePath() . "/" . $path);
    }
    protected function validatePath($path)
    {
        $path = "/" . ltrim($path, "/");

        if (preg_match('![^a-zA-Z0-9_/]!', $path)) {
            throw new BadRequestHttpException();
        }
        if (!file_exists(self::getBasePath() . $path)) {
            throw new NotFoundHttpException();
        }

        return $path;
    }
    protected function getBreadcrumbs($path)
    {
        $path = trim($path,"/");
        $parts = $path ? explode("/", "/" . $path) : [''];
        $first = array_key_first($parts);
        $last = array_key_last($parts);
        $breadpath = '';

        foreach ($parts as $key => $item) {
            $breadcrumbs[] = [
                'path' => $breadpath .=  $item . "/",
                'label' => $item ?: '/',
                'first' => $key === $first,
                'last' => $key === $last,
            ];
        }
#        var_dump($breadcrumbs);die;
        return $breadcrumbs;
    }
}
