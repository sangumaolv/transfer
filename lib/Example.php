<?php

class Example
{

    public function up()
    {
        $sql = "";
        return (new Db)->query($sql);
    }

    public function down()
    {
        $sql = "";
        return (new Db)->query($sql);
    }
}
