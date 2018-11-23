<?php
/**
 * 配置文件
 */

class Runlog
{

    /**
     * 获取已经运行的文件
     * @return bool|int|mixed|string
     */
    public static function getInfo()
    {
        $path = ROOT . 'lib/run.log';
        //验证记录文件是否存在
        if (!file_exists($path)) {
            $re = file_put_contents($path, '');//不存在则创建
            $re = empty($re) ? [] : $re;
        } else {
            $re = file_get_contents($path);
            $re = json_decode($re, true);
        }
        return $re;
    }


    /**
     * 修改运行迁移过的文件
     * @param $fileName
     * @param $type
     * @return bool|int
     */
    public static function upData($fileName, $type = 'add')
    {
        $runLog = self::getInfo();
        if ($type == 'add') {
            $runLog[$fileName]['date'] = date('YmdHis', time());
        } else {
            unset($runLog[$fileName]);
        }

        return file_put_contents(ROOT . 'lib/run.log', json_encode($runLog));
    }


}
