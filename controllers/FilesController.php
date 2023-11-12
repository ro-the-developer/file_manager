<?php

namespace app\controllers;

use app\models\FolderForm;
use app\models\UploadForm;
use Yii;
use yii\helpers\FileHelper;
use yii\filters\AccessControl;
use yii\web\Controller;

class FilesController extends Controller
{
    /**
     * Displays the main files page.
     *
     * @return string
     */
    public function actionIndex()
    {
        $path = FolderController::validatePath(Yii::$app->request->get('path', ''));

        return $this->render('index',[
            'folderModel' => new FolderForm(),
            'uploadModel' => new UploadForm(),
            'files' => $this->getFilenames($path),
            'folders' => $this->getFolders($path),
            'path' => $path,
            'breadcrumbs' => $this->getBreadcrumbs($path),
        ]);
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
        return $breadcrumbs;
    }
    protected function getFilenames($path)
    {
        return array_map('basename',
            FileHelper::findFiles(
                FolderController::getBasePath() . $path,
                ['recursive' => false, 'except' => ['.*']]
            )
        );
    }

    protected function getFolders($path)
    {
        return array_map('basename',
            FileHelper::findDirectories(FolderController::getBasePath() . $path, ['recursive' => false])
        );
    }
}
