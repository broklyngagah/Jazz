<?php

namespace Jazz\Demo\Repository;

class DemoRepository
{

    public static function getUser(\Jazz\Application $app)
    {
        $sql = "Select * from user";
        $query = $app['db']->prepare($sql);
        $query->execute();

        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }
}