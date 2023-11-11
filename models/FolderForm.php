<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class FolderForm extends Model
{
    public $name;
    public $path;
    public $recursive;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['name', 'path'], 'required'],
            ['name', 'match', 'pattern' => '/^[a-zA-Z0-9_]+$/'],
            ['path', 'match', 'pattern' => '/^[a-zA-Z0-9_\/]+$/'],
        ];
    }
}
