<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class MkdirForm extends Model
{
    public $dir;
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['dir', 'path'], 'required'],
            ['dir', 'match', 'pattern' => '/^[a-zA-Z0-9_]+$/'],
            ['path', 'match', 'pattern' => '/^[a-zA-Z0-9_\/]+$/'],
        ];
    }
}
