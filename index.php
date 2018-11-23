<?php
/**
 * Created by PhpStorm.
 * User: 10909
 * Date: 2018/11/21
 * Time: 16:21
 */
define('ROOT', __DIR__ . '/');
require ROOT . 'lib/Db.php';
require ROOT . 'lib/Commen.php';
require ROOT . 'lib/Runlog.php';
list($index, $key, $value) = $argv;

switch ($key) {
    case 'create'://创建迁移文件
        $re = (new Commen)->create($value);
        die('Successful operation');
        break;
    case 'up'://运行迁移文件
       (new Commen)->up($value);
        break;
    case 'down'://运行迁移文件
        (new Commen)->down($value);
        break;
    case 'status'://运行状态
        (new Commen)->status();
        break;
}



