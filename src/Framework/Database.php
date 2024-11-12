<?php

declare(strict_types=1);

namespace Framework;

use PDO;
use PDOException;
use PDOStatement;

class Database
{

    private PDO $connection;
    private PDOStatement $stmt;

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
            $this->connection = new PDO($dsn, $username, $password, [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function query(string $query, array $params = [])
    {
        $this->stmt = $this->connection->prepare($query);
        $this->stmt->execute($params);

        return $this;
    }

    public function count()
    {
        return $this->stmt->fetchColumn();
    }

    public function fetch()
    {
        return $this->stmt->fetch();
    }

    public function id()
    {
        return $this->connection->lastInsertId();
    }
}
