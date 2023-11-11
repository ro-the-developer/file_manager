<?php

namespace app\models;

use yii\db\ActiveRecord;

class FilesLog extends ActiveRecord
{
    public function rules()
    {
        return [
            ['user_id', 'integer'],
            ['action', 'string'],
            ['request', 'string']
        ];
    }
}
