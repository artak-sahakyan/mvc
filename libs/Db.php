<?php


namespace libs;


use PDO;

class Db extends DefaultLib
{

    protected static $instance;

    protected $dsn = 'mysql:host=localhost;dbname=mvc_tasks';
    protected $username = 'root';
    protected $password = '123456';

    protected $pdo;


    protected function __construct()
    {
        $this->pdo = new PDO($this->dsn, $this->username, $this->password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function queryOne($query, $binds = [])
    {
        $query = $this->query($query, $binds);
        return $query->fetch();
    }

    public function query($sql, $binds = [])
    {
        $query = $this->pdo->prepare($sql);
        $query->execute($binds);
        $query->setFetchMode(PDO::FETCH_OBJ);
        return $query;
    }

    public function queryAll($query, $binds = [])
    {
        $query = $this->query($query, $binds);
        return $query->fetchAll();
    }

    public function lastInsertedId()
    {
        return $this->pdo->lastInsertId();
    }

}