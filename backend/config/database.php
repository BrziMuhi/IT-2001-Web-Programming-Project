<?php
class Database {
    private static ?PDO $conn = null;

    public static function getConnection(): PDO {
        if (self::$conn === null) {
            $host = '127.0.0.1';
            $port = 3306; 
            $db   = 'travel_usk';
            $user = 'root';
            $pass = '';

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
