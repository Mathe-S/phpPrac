<?php

declare(strict_types=1);

namespace Framework;

use PDO;
use PDOException;

class Database
{

    private PDO $connection;

    public function __construct(string $driver, string $username, string $password)
    {
        // $config = http_build_query(data: [
        //     'host' => 'localhost',
        //     'port' => 3306,
        //     'dbname' => 'phpPrac',
        // ], arg_separator: ';');
        // $dsn = "{$driver}:{$config}";

        $dsn = "{$driver}:unix_socket=/Applications/XAMPP/xamppfiles/var/mysql/mysql.sock;dbname=phpPrac";


        try {
            $this->connection = new PDO($dsn, $username, $password);
            echo "Connected to database\n";
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function query(string $query)
    {
        $this->connection->query($query);
    }
}
