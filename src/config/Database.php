<?php  
namespace src\config;

use PDO;
use PDOException;



class Database{
    private static ?PDO $instance = null;

    public static function getConnection():PDO
    {
        if (self::$instance === null) {
            $host     = $_ENV['DB_HOST']     ?? 'localhost';
            $port     = $_ENV['DB_PORT']     ?? '3306';
            $dbName   = $_ENV['DB_NAME']     ?? 'stock_management_system';
            $user     = $_ENV['DB_USER']     ?? 'root';
            $password = $_ENV['DB_PASSWORD'] ?? '';

            $dsn = "mysql:host={$host};port={$port};dbname={$dbName};charset=utf8mb4";

            try {
                self::$instance = new PDO($dsn, $user, $password, [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                ]);
            } catch (PDOException $e) {
                error_log('Database connection failed: ' . $e->getMessage());
                throw $e;
            }
        }

        return self::$instance;
    }
    private function __construct() {}
    private function __clone() {}
}


?>