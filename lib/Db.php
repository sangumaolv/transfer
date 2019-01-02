<?php


class Db
{
    public $dsn;
    public $dbh;

    public function __construct()
    {
        $database = require ROOT . 'lib/Database.php';
        try {
            $this->dsn = 'mysql:host=' . $database['hostname'] . ';dbname=' . $database['database'];
            $this->dbh = new PDO($this->dsn, $database['username'], $database['password']);
            $this->dbh->exec('SET character_set_connection=' . $database['charset'] . ', character_set_results=' . $database['charset'] . ', character_set_client=binary');
        } catch (PDOException $e) {
            die($e->getMessage());
        }

    }

    public function query($sql)
    {
       return $this->dbh->query($sql);

    }
}