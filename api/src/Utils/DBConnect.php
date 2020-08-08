<?php
namespace FootballBlog\Utils;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class DBConnect{
    private $username = DBConfig::DB_USER;
    private $dbName = DBConfig::DB_NAME;
    private $password = DBConfig::DB_PASS;
    private $host = DBConfig::DB_HOST;

    private $log;

    public function dbConnection(){
        $conn = mysqli_connect($this->host,$this->username,$this->password,$this->dbName);

        if (!$conn){
            $this->log = new Logger("DBConnect");
            $errorStreamHandler = new StreamHandler("runtime/logs/error.log",Logger::ERROR);
            $this->log->pushHandler($errorStreamHandler);
            $this->log->error("Connection failed ".mysqli_connect_error());
        }

        return $conn;
    }
}