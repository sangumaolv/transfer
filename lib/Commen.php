<?php
/**
 * 配置文件
 */

class Commen
{
    /**
     * 创建迁移文件
     * @param $className
     * @return bool
     */
    public function create($className)
    {
        if (!preg_match("/^[A-Z]{1}([a-z]){3,19}$/", $className)) {
            die('Migration names can only be 4-20-bit letters in length, with the initials capitalized');
        }
        $allDatabase = self::allDatabase();
        if (in_array($className, $allDatabase)) {
            die('The name already exists');
        }

        $date = date('YmdHis', time());
        $fileName = ROOT . 'database/' . $date . "_$className" . '.php';
        $file = fopen($fileName, "w") or die("Unable to open file!");

        $txt = file_get_contents(ROOT . 'lib/Example.php');
        $txt = str_replace('Example', $className, $txt);
        fwrite($file, $txt);
        fclose($file);
        return true;
    }

    /**
     * 运行迁移文件
     * @param $value
     */
    public function up($value)
    {
        //获取已经运行的文件
        $run_log = Runlog::getInfo();
        $re = self::allDatabase($value);
        foreach ($re as $k => $v) {
            if ($run_log[$k]) {//已经执行过了
                continue;
            }
            $path = ROOT . 'database/' . $k;//迁移文件路径
            //运行文件
            $re = self::upSql($path, $v, $k);
            if ($re) {
                echo $k . "    Successful \n";
            } else {
                echo $k . "    Fail \n";
            }
        }
    }

    /**
     * 回滚迁移文件
     * @param $value
     */
    public function down($value)
    {
        //获取已经运行的文件
        $run_log = Runlog::getInfo();
        $re = self::allDatabase($value);

        foreach ($re as $k => $v) {
            if ($run_log[$k]) {//已经执行过了
                $path = ROOT . 'database/' . $k;//迁移文件路径
                //运行文件
                $re = self::downSql($path, $v, $k);
                if ($re) {
                    echo $k . "    Successful \n";
                } else {
                    echo $k . "    Fail \n";
                }
            }
            continue;

        }
    }


    /**
     * 查看迁移文件运行状态
     */
    public function status()
    {
        $re = self::allDatabase();//获取所有迁移文件
        $runLog = Runlog::getInfo();//获取已经运行后的迁移文件

        foreach ($re as $k => $v) {
            if ($runLog[$k]) {
                echo $k . "    " . $runLog[$k]['date'] . "\n";
            } else {
                echo $k . "    UP\n";
            }
        }
    }

    /**
     * 查找所有迁移文件
     * @param null $fileName
     * @return array
     */
    public static function allDatabase($fileName = NULL)
    {
        //查找所有迁移文件
        $dir = ROOT . 'database/';
        $re = [];
        if ($dh = opendir($dir)) {
            while (($file = readdir($dh)) !== false) {
                if (strlen($file) > 9) {
                    $files = explode('_', $file);
                    if (!empty($fileName) && $files['0'] != $fileName) {
                        continue;
                    }
                    $re[$file] = str_replace(".php", "", $files[1]);
                }
            }
        }
        return $re;
    }

    /**
     * 执行迁移文件
     * @param $path
     * @param $className
     * @param $fileName
     * @return bool|int
     */
    static function upSql($path, $className, $fileName)
    {
        require $path;
        $re = (new $className)->up();
        if ($re !== false) {
            return Runlog::upData($fileName);
        }
        return false;
    }

    /**
     * 回滚迁移文件
     * @param $path
     * @param $className
     * @param $fileName
     * @return bool|int
     */
    static function downSql($path, $className, $fileName)
    {
        require $path;
        $re = (new $className)->down();
        if ($re !== false) {
            return Runlog::upData($fileName, 'del');
        }
        return false;
    }
}
