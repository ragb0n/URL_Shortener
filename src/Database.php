<?php

declare(strict_types=1);

namespace App;

use PDO;

class Database
{
    private PDO $conn;

    public function __construct(array $config)
    {
        $this->createConnection($config);
    }

    public function shortenURL(array $data): void
    {
        $beforeURL = $this->conn->quote($data['beforeURL']);
        $afterURL = $this->conn->quote($data['afterURL']);
        $query = "INSERT INTO urls(beforeURL, afterURL) VALUES($beforeURL, $afterURL)";

        $this->conn->exec($query);
    }

    public function resolveURL(string $id): array
    {
        $query = "SELECT beforeURL FROM urls WHERE afterURL = '$id'";
        $result = $this->conn->query($query);
        return $result->fetch(PDO::FETCH_ASSOC);
    }

    private function createConnection(array $config): void
    {
        $dsn = "mysql:dbname={$config['database']};host={$config['host']}";
        $this->conn = new PDO (
            $dsn,
            $config['user'],
            $config['password'],
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]
            );
    }
}