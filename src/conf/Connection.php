<?php

class Connection
{
    static private $hostname = 'localhost';
    static private $database = 'DATABASE_NAME';
    static private $login = 'USER_LOGIN';
    static private $password = 'USER_PASSWORD';
    static private $encoding = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
    static private $pdo;

    // Getter
    static public function getPDO()
    {
        return self::$pdo;
    }

    // Methods
    static public function connect()
    {
        $hostname = self::$hostname;
        $database = self::$database;
        $login = self::$login;
        $password = self::$password;
        $encoding = self::$encoding;

        try {
            self::$pdo = new PDO("mysql:host=$hostname;dbname=$database", $login, $password, $encoding);
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "<strong style='color: red'> Connection error: " . $e->getMessage() . "<br></strong>";
        }
    }
}

?>
