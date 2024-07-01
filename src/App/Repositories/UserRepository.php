<?php

declare(strict_types=1);

namespace App\Repositories;

use PDO;
use App\Database;

class UserRepository
{
    private PDO $connection;

    public function __construct(
        private Database $database,
    ) {
        $this->connection = database::getConnection();
    }

    public function create(array $data): bool|string
    {
        $query = 'INSERT INTO user (name, email, password, api_key, api_key_hashed)
        VALUES (:name, :email, :password, :api_key, :api_key_hashed)';

        $stmt = $this->connection->prepare($query);

        $stmt->bindValue(':name', $data['name']);
        $stmt->bindValue(':email', $data['email']);
        $stmt->bindValue(':password', $data['password']);
        $stmt->bindValue(':api_key', $data['api_key']);
        $stmt->bindValue(':api_key_hashed', $data['api_key_hashed']);

        $stmt->execute();

        return $this->connection->lastInsertId();
    }

    public function find(string $column, $value): array
    {
        $query = "SELECT * FROM user WHERE {$column} = :value";

        $stmt = $this->connection->prepare($query);
        $stmt->bindValue(':value', $value);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
