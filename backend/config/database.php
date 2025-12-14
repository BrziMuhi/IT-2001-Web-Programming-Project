<?php

require_once __DIR__ . '/config.php';



class Database {
    private static ?PDO $conn = null;

    public static function getConnection(): PDO {
        if (self::$conn === null) {
            $host = Config::DB_HOST();
            $port = Config::DB_PORT();
            $db   = Config::DB_NAME();
            $user = Config::DB_USER();
            $pass = Config::DB_PASSWORD();

            $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4";
            $opt = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ];

            self::$conn = new PDO($dsn, $user, $pass, $opt);
        }

        return self::$conn;
    }
}

?>