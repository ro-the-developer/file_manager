<?php

namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $file;
    public $path;

    public function rules()
    {
        return [
            [['file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
            ['path', 'match', 'pattern' => '/^[a-zA-Z0-9_\/]+$/'],
        ];
    }

    public function upload($path)
    {
        if ($this->validate()) {
            $this->file->saveAs($path . '/' . $this->file->baseName . '.' . $this->file->extension);
            return true;
        } else {
            return false;
        }
    }
}