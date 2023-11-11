<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'sqlite:'. realpath(__DIR__ . '/../') . "/db.sqlite",
    'charset' => 'utf8',
    'enableSchemaCache' => true,
];
