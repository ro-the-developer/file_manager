<?php

namespace app\controllers;

use app\models\FilesLog;
use yii\helpers\Url;
use Yii;
use yii\helpers\FileHelper;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class FolderController extends Controller
{
    public function beforeAction($action)
    {
        $request = json_encode(Yii::$app->request->post()['FolderForm'], JSON_UNESCAPED_SLASHES );
        $model = new FilesLog([
            'user_id' => Yii::$app->user->id,
            'action' => $action->id,
            'request' => $request
        ]);
        $model->insert();

        return parent::beforeAction($action);
    }

    public function actionCreate()
    {
        $path = self::validatePath(Yii::$app->request->post()['FolderForm']['path']);
        $dir = Yii::$app->request->post()['FolderForm']['name'];
        $newDir = self::getBasePath() . $path . "/" . $dir;

        if (file_exists($newDir)) {
            Yii::$app->session->setFlash('error', "Folder $dir already exists.");
        } else {
            FileHelper::createDirectory($newDir);
            $path .= "/" . $dir;
            Yii::$app->session->setFlash('success', "Folder created successfully");
        }
        $this->redirect(Url::to(['files/index', 'path' => $path]), 302);
    }

    public function actionRename()
    {
        $path = self::validatePath(Yii::$app->request->post()['FolderForm']['path']);
        if ($path === "/") {
            throw new BadRequestHttpException();
        }

        $old = basename($path);
        $path = self::getDirname($path);

        $old = $path . "/" . $old;

        $new = Yii::$app->request->post()['FolderForm']['name'];
        $new = $path . "/" . $new;

        rename(self::getBasePath() . $old, self::getBasePath() . $new);

        Yii::$app->session->setFlash('success', "Folder renamed successfully");
        $this->redirect(Url::to(['files/index', 'path' => $new]), 302);
    }

    public function actionDelete()
    {
        $path = $this->validatePath(Yii::$app->request->post()['FolderForm']['path']);
        if ($path === "/") {
            throw new BadRequestHttpException();
        }

        $toDelete = self::getBasePath() . $path;
        $recursive = Yii::$app->request->post()['FolderForm']['recursive'] ?? 0;

        if (!$recursive && !self::checkFolderIsEmpty($toDelete)) {
            Yii::$app->session->setFlash('error', "Error: folder is not empty.");
        } else {
            FileHelper::removeDirectory($toDelete);
            $path = self::getDirname($path);
            Yii::$app->session->setFlash('success', "Folder deleted successfully.");
        }
        $this->redirect(Url::to(['files/index', 'path' => $path]), 302);
    }

    public static function getBasePath()
    {
        return Yii::$app->basePath . "/" . Yii::$app->params['filesModule']['path'];
    }

    public static function validatePath($path)
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

    public static function getDirname($path)
    {
        return str_replace ("\\", "/", dirname($path));
    }

    public static function checkFolderIsEmpty($dir) {
        $handle = opendir($dir);
        while (false !== ($entry = readdir($handle))) {
            if ($entry != "." && $entry != "..") {
                closedir($handle);
                return false;
            }
        }
        closedir($handle);
        return true;
    }
}
