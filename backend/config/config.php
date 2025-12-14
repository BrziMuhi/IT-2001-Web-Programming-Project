<?php
class Config {

    public static function DB_HOST() {
        return '127.0.0.1';
    }

    public static function DB_PORT() {
        return 3306;
    }

    public static function DB_NAME() {
        return 'travel_usk';
    }

    public static function DB_USER() {
        return 'root';
    }

    public static function DB_PASSWORD() {
        return '';
    }

    public static function JWT_SECRET() {
        return 'your_secret_key_here';
    }
}
