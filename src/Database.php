<?php

declare(strict_types=1);

namespace App;

use App\Exceptions\ConfigurationException;
use App\Exceptions\StorageException;
use PDO;
use PDOException;
use Throwable;

class Database
{
    private PDO $conn;

    public function __construct(array $config)
    {
        try {
            $this->validateConfig($config);
            $this->createConnection($config);
        } catch (PDOException $e) 
        {
            throw new StorageException('Błąd połączenia');
        }
    }

    public function shortenURL(array $data): void
    {
        try {
            $beforeURL = $this->conn->quote($data['beforeURL']);
            $afterURL = $this->conn->quote($data['afterURL']);
            $query = "INSERT INTO urls(beforeURL, afterURL) VALUES($beforeURL, $afterURL)";
            $this->conn->exec($query);
        } catch (Throwable $e)
        {
            throw new StorageException('Nie udało się skrócić adresu', 400, $e);
        }
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

    private function validateConfig(array $config): void
  {
    if (
      empty($config['database'])
      || empty($config['host'])
      || empty($config['user'])
      || empty($config['password'])
    ) {
      throw new ConfigurationException('Storage configuration error');
    }
  }
}